<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerOrderResource\Pages;
use App\Filament\Resources\CustomerOrderResource\RelationManagers;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\ScheduleDeliveryStock;
use App\Models\Item;
use App\Models\Outlet;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;

class CustomerOrderResource extends Resource
{
    protected static ?string $model = CustomerOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Consumer';

    public static function getNavigationSort(): ?int
    {
        return 12;
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
                        'md'=>2,
                        'lg' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('outlet_id')->label('Select Outlet')->searchable()
                            ->options(Outlet::where('city_id',auth()->user()->userCustomer->city_id)->pluck('outlet_name','id'))
                           ,
                            // ->options(Outlet::pluck('outlet_name','id'))->rules(['required']),
                        Forms\Components\DatePicker::make('order_date')->readOnly()->default(now()),
                    ])

                ]),
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                        Forms\Components\Grid::make([
                            'sm'=>1,
                            'md'=>2,
                            'lg' => 2,
                        ])
                        ->schema([
                            Forms\Components\Select::make('item_id')->label('Select Item')
                                ->options(fn (Get $get) => Item::pluck('name','id'))->rules(['required'])->searchable(),
                            Forms\Components\TextInput::make('qty')
                                ->extraInputAttributes(['style'=>'text-align:right'])
                                ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        if ($get('qty') <= '0.00' ) {
                                            $fail("The Quantity of item must be greater than 0.");
                                        }
                                    },
                                ])
                                ->afterStateUpdated(function (Get $get,Set $set)
                                {

                                    // dd($get('outlet_id'));
                                    $stock = Stock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->sum('qty');
                                    $stockOrderedQty = CustomerOrderItem::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->where('schedule_delivery_id',null)->sum('qty');
                                    $customerOrderedQty = CustomerOrderItem::where('customer_id',auth()->user()->customer_id)->where('status','Order Pending')->sum('qty');
                                    if ($get('qty') > '0.00' )
                                    {
                                        if($get('qty') + $customerOrderedQty > auth()->user()->userCustomer->cylinder_limit)
                                        {
                                            Notification::make()
                                                ->warning()
                                                ->title('Warning!!')
                                                ->body('You are exceeding your cylinder limit. Please check the quantity.')
                                                ->send();
                                            $set('item_id',null);
                                            $set('qty',null);
                                            $set('sales_price',null);
                                            $set('total',null);
                                            $set('schedule_delivery_id',null);
                                            return;
                                        }

                                        if($get('qty') + $stockOrderedQty > $stock)
                                        {
                                            $scheduledStock = ScheduleDeliveryStock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->get();
                                            // dd($scheduledStock->count());
                                            
                                            if($scheduledStock->count() > 0)
                                            {
                                                foreach ($scheduledStock as $schedule) 
                                                {
                                                    $scheduleOrderedQty = CustomerOrderItem::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->where('schedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                                                    if($scheduleOrderedQty + $get('qty') <= $schedule->qty)
                                                    {
                                                        $set('sales_price',$schedule->sales_price);
                                                        $set('total',$schedule->sales_price * $get('qty'));
                                                        $set('schedule_delivery_id',$schedule->schedule_delivery_id);
                                                        break;
                                                    }
                                                }
                                                if($get('schedule_delivery_id') == null)
                                                {
                                                    Notification::make()
                                                        ->warning()
                                                        ->title('Warning!!')
                                                        ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                                                        ->send();
                                                    $set('item_id',null);
                                                    $set('qty',null);
                                                    $set('sales_price',null);
                                                    $set('total',null);
                                                    $set('schedule_delivery_id',null);
                                                    return;
                                                }
                                                
                                            }
                                            else
                                            {
                                                Notification::make()
                                                    ->warning()
                                                    ->title('Warning!!')
                                                    ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                                                    ->send();
                                                $set('item_id',null);
                                                $set('qty',null);
                                                $set('sales_price',null);
                                                $set('total',null);
                                                $set('schedule_delivery_id',null);
                                                return;
                                            }
                                            // $scheduledStock->sum('qty') < $get('qty') + CustomerOrderStock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))
                                        }
                                        else
                                        {
                                            $latestStock = Stock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->latest('id')->first();
                                            $set('sales_price',$latestStock->sales_price);
                                            $set('total',$latestStock->sales_price * $get('qty'));
                                        }
                                    }
                                    else
                                    {
                                        Notification::make()
                                            ->warning()
                                            ->title('Warning!!')
                                            ->body('Please enter correct qty.')
                                            ->send();
                                    }
                                })->live(),
                            Forms\Components\TextInput::make('schedule_delivery_id')->hidden(),
                            Forms\Components\TextInput::make('sales_price')->readOnly(),
                            Forms\Components\TextInput::make('total')->readOnly()
                        ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('customerOrderCity.name_en')
                    ->label('City Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerOrderCustomer.mobile_no')
                    ->label('Customer Mobile')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('token_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->searchable(),
                
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                Filter::make('invoice_date')
                        ->form([
                            DatePicker::make('created_from')->label('Start Date')
                                ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                            DatePicker::make('created_until')->label('End Date')
                                ->placeholder(fn ($state): string => now()->format('M d, Y')),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['created_from'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('order_date', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('order_date', '<=', $date),
                                );
                        })
                        ->indicateUsing(function (array $data): array {
                            $indicators = [];
                            if ($data['created_from'] ?? null) {
                                $indicators['created_from'] = 'Order from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                            }
                            if ($data['created_until'] ?? null) {
                                $indicators['created_until'] = 'Order until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                            }

                            return $indicators;
                        }),
                SelectFilter::make('status')
                ->options([
                    'Order Pending' => 'Order Pending',
                    'Canceled' => 'Canceled',
                    'Finished' => 'Finished'
                ])
                ->label('Status')
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Order'),
                Tables\Actions\Action::make('changeStatus')->label('')->icon('heroicon-o-arrow-path')->toolTip('Cancel Order')
                    ->hidden(fn () : bool => auth()->user()->hasPermissionTo('Update_CustomerOrder') ? false : true)
                    ->visible(fn (CustomerOrder $record) : bool => $record->status == 'Order Pending' ? true : false)
                    ->form([
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Canceled'=>'Canceled',
                            ]),
                    ])
                    ->action(function (CustomerOrder $record, array $data)
                    {
                        
                        $invoiceItem = CustomerOederItem::where('customer_order_id',$record->id)->update(['status'=>'Canceled']);
                        $record->status = $data['status'];
                        $record->update();

                        Notification::make()
                            ->warning()
                            ->title('Warning!!')
                            ->body('The Order has been canceled successfully.')
                            ->send();

                    })
                    ->modalWidth(MaxWidth::Small),  
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
            'index' => Pages\ListCustomerOrders::route('/'),
            'create' => Pages\CreateCustomerOrder::route('/create'),
            // 'edit' => Pages\EditCustomerOrder::route('/{record}/edit'),
            'view' => Pages\ViewCustomerOrder::route('/{record}/show'),
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
        else if(auth()->user()->getRoleNames()->first() == 'Customer')
        {
            return parent::getEloquentQuery()
            ->where('customer_id',auth()->user()->customer_id)
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
