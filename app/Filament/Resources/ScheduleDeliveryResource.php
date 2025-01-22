<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleDeliveryResource\Pages;
use App\Filament\Resources\ScheduleDeliveryResource\RelationManagers;
use App\Models\ScheduleDelivery;
use App\Models\ScheduleDeliveryStock;
use App\Models\Stock;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use App\Models\Outlet;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Closure;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;

class ScheduleDeliveryResource extends Resource
{
    protected static ?string $model = ScheduleDelivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Item';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>3,
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\Select::make('province_id')->label('Select Province')->rules(['required'])
                            ->options(Province::whereIn('id',Outlet::pluck('province_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('district_id')->label('Select District')->rules(['required'])
                            ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->whereIn('id',Outlet::pluck('district_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('city_id')->label('Select City')->rules(['required'])
                            ->options(fn (Get $get) => City::where('district_id',$get('district_id'))->whereIn('id',Outlet::pluck('city_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                    ]),
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('outlet_id')->label('Select Outlet')
                            ->options(fn (Get $get) => Outlet::where('city_id',$get('city_id'))->pluck('outlet_name','id'))->rules(['required'])->searchable(),
                        Forms\Components\DatePicker::make('scheduled_date')->rules(['required'])->native(false)->minDate(now()),
                    ])
                    ]),
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Repeater::make('Stock')
                    ->relationship('scheduleDeliveryStocks')
                    ->schema([
                        Forms\Components\Grid::make([
                            'sm'=>1,
                            'md'=>3,
                            'lg' => 3,
                        ])
                        ->schema([
                            Forms\Components\Select::make('item_id')->label('Select Item')
                                ->options(fn (Get $get) => Item::pluck('name','id'))->rules(['required'])->searchable(),
                            Forms\Components\TextInput::make('batch_no')
                                ->numeric()->rules(['required'])->label('Batch Number'),
                            Forms\Components\TextInput::make('qty')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('qty') <= '0.00' ) {
                                            $fail("The Quantity of item must be greater than 0.");
                                        }
                                    },
                                ]),
                        ]),
                        Forms\Components\Grid::make([
                            'sm'=>1,
                            'md'=>2,
                            'lg' => 2,
                        ])
                        ->schema([
                                Forms\Components\TextInput::make('cost_price')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('cost_price') <= '0.00' ) {
                                            $fail("The Cost Price must be greater than 0.");
                                        }
                                    },
                                ]),
                                Forms\Components\TextInput::make('sales_price')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('sales_price') <= '0.00') {
                                            $fail("The Selling Price must be greater than 0.");
                                        }
                                        if ($get('sales_price') < $get('cost_price')) {
                                            $fail("The Selling Price must be greater than cost price.");
                                        }
                                    },
                                ]),
                        ])
                    ])
                ])
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 
                Tables\Columns\TextColumn::make('scheduleDeliveryDistrict.name_en')
                    ->label('District Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleDeliveryOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedule_no')
                    ->label('Schedule Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_of_item')
                    ->searchable()->label('Items'),
                Tables\Columns\TextColumn::make('no_of_qty')
                    ->searchable()->label('Qtys'),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total')),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Schedule Delivery'),
                // Tables\Actions\EditAction::make()->label('')->toolTip('Edit Schedule Delivery'),
                Tables\Actions\Action::make('changeStatus')->label('')->icon('heroicon-o-arrow-path')
                    ->hidden(fn () : bool => auth()->user()->hasPermissionTo('Update_ScheduleDelivery') ? false : true)
                    ->form([
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Canceled'=>'Canceled',
                                'Confirmed'=>'Confirmed',
                            ])->hidden(fn (ScheduleDelivery $record):bool=>$record->status == 'Scheduled' ? false : true),
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Dispatched'=>'Dispatched',
                            ])->hidden(fn (ScheduleDelivery $record):bool=>$record->status == 'Confirmed' ? false : true),
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Delivered'=>'Delivered',
                            ])->hidden(fn (ScheduleDelivery $record):bool=>$record->status == 'Dispatched' ? false : true),
                    ])
                    ->action(function (ScheduleDelivery $record, array $data)
                    {
                        $record->status = $data['status'];
                        if($data['status'] == 'Canceled')
                        {
                            $orderItems = CustomerOrderItem::where('schedule_delivery_id',$record->id)->get();
                            foreach ($orderItems as $orderItem) 
                            {
                                $orderItem->status = 'Canceled';
                                $orderItem->update();

                                CustomerOrder::where('id',$orderItem->customer_order_id)->update(['status'=>'Canceled']);
                            }
                        }
                        if($data['status'] == 'Confirmed')
                        {
                            $countOrders = CustomerOrder::where('status','Order Pending')->where('schedule_delivery_id',$record->id)->count();
                            if($countOrders > 0)
                            {
                                $orders = CustomerOrder::where('status','Order Pending')->where('schedule_delivery_id',$record->id)->get();
                                foreach ($orders as $order) 
                                {
                                    Mail::to($order->customerOrderCustomer->email)->send(new SendVerifiedMail([
                                        'title' => 'Scheduled Delivery Has Been Verified',
                                        'sayHello' => 'Dear '.$order->customerOrderCustomer->full_name,
                                        'body' => 'The scheduled delivery has been confirmed. Please bring your empty cylinders and make payments at you ordered outlet.
                                                    you will recieve your filled cylinder after '.$record->scheduled_date.' . If you could not return empties or make
                                                    payments, Please contact your outlet manager and reschedule your order.'
                                    ]));
                                }
                                
                            }
                        }
                        if($data['status'] == 'Dispatched')
                        {
                            $record->dispatched_by = auth()->user()->id;
                        }
                        if($data['status'] == 'Delivered')
                        {
                            $record->recieved_by = auth()->user()->id;
                            $record->recieved_date = Carbon::now()->format('Y-m-d');
                            $deliveryStocks = ScheduleDeliveryStock::where('schedule_delivery_id',$record->id)->get();
                            foreach ($deliveryStocks as $deliveryStock) 
                            {
                                $stock = new Stock;
                                $stock->province_id = $deliveryStock->province_id;
                                $stock->district_id = $deliveryStock->district_id;
                                $stock->city_id = $deliveryStock->city_id;
                                $stock->outlet_id = $deliveryStock->outlet_id;
                                $stock->schedule_delivery_id = $deliveryStock->schedule_delivery_id;
                                $stock->qty = $deliveryStock->qty;
                                $stock->item_id = $deliveryStock->item_id;
                                $stock->batch_no = $deliveryStock->batch_no;
                                $stock->cost_price = $deliveryStock->cost_price;
                                $stock->sales_price = $deliveryStock->sales_price;
                                $stock->user_id = auth()->user()->id;
                                $stock->stock_date = Carbon::now()->format('Y-m-d');
                                $stock->save();
                            }
                        }
                        $record->update();
                        ScheduleDeliveryStock::where('schedule_delivery_id',$record->id)->update(['status'=>$data['status']]);

                        Notification::make()
                            ->warning()
                            ->title('Warning!!')
                            ->body('The scheduled delivery status has been updated.')
                            ->send();
                    })
                    ->modalWidth(MaxWidth::Small),
                // Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Schedule Delivery'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScheduleDeliveries::route('/'),
            'create' => Pages\CreateScheduleDelivery::route('/create'),
            // 'edit' => Pages\EditScheduleDelivery::route('/{record}/edit'),
            'view' => Pages\ViewScheduleDelivery::route('/{record}/show'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return parent::getEloquentQuery()
            ->where('outlet_id',auth()->user()->userEmployee->outlet_id)
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
        }
        else
        {
            return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
        }
    }
}
