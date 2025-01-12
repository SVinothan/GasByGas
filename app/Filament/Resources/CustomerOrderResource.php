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

class CustomerOrderResource extends Resource
{
    protected static ?string $model = CustomerOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Consumer';

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
                        Forms\Components\Select::make('outlet_id')
                            // ->options(Outlet::where('city_id',auth()->user()->userCustomer->city_id)->pluck('outlet_name','id')),
                            ->options(Outlet::pluck('outlet_name','id'))->rules(['required']),
                        Forms\Components\DatePicker::make('order_date')->readOnly()->default(now()),
                    ])

                ]),
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Repeater::make('Items')
                    ->relationship('customerOrderItems')
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
                                    $stock = Stock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->sum('qty');
                                    $stockOrderedQty = CustomerOrderItem::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->where('shedule_delivery_id',null)->sum('qty');

                                    if($get('qty') + $stockOrderedQty > $stock)
                                    {
                                        $scheduledStock = ScheduleDeliveryStock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->whereIn('status',['Scheduled','Confirmed'])->where('scheduled_date','<',Carbon::now()->addDays(14)->format('Y-m-d'))->get();
                                        if($scheduledStock != null)
                                        {
                                            foreach ($scheduledStock as $schedule) 
                                            {
                                                $scheduleOrderedQty = CustomerOrderItem::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->where('shedule_delivery_id',$schedule->schedule_delivery_id)->sum('qty');
                                                if($scheduleOrderedQty + $get('qty') <= $schedule->qty)
                                                {
                                                    $set('sales_price',$schedule->amount);
                                                    $set('total',$schedule->amount * $get('qty'));
                                                    $set('shedule_delivery_id',$schedule->shedule_delivery_id);
                                                    break;
                                                }
                                            }
                                            Notification::make()
                                                ->warning()
                                                ->title('Warning!!')
                                                ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                                                ->send();
                                            $set('item_id',null);
                                            $set('qty',null);
                                            return;
                                        }
                                        Notification::make()
                                            ->warning()
                                            ->title('Warning!!')
                                            ->body('There are no stock availabe. Try again later Or contact outlet manager.')
                                            ->send();
                                        $set('item_id',null);
                                        $set('qty',null);
                                        return;
                                        // $scheduledStock->sum('qty') < $get('qty') + CustomerOrderStock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))
                                    }
                                    else
                                    {
                                        $latestStock = Stock::where('item_id',$get('item_id'))->where('outlet_id',$get('outlet_id'))->latest('id')->first();
                                        $set('amount',$latestStock->sales_price);
                                        $set('total',$latestStock->sales_price * $get('qty'));
                                    }
                                })->live(),
                            Forms\Components\TextInput::make('shedule_delivery_id')->hidden(),
                            Forms\Components\TextInput::make('amount')->readOnly(),
                            Forms\Components\TextInput::make('total')->readOnly()
                        ])
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderCustomer.fist_name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerOrderCustomer.last_name')
                    ->label('Last Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('token_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->searchable(),
                
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
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
            'edit' => Pages\EditCustomerOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
            ]);
    }
}
