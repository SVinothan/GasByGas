<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerInvoiceResource\Pages;
use App\Filament\Resources\CustomerInvoiceResource\RelationManagers;
use App\Models\CustomerInvoice;
use App\Models\CustomerInvoiceItem;
use App\Models\CustomerOrder;
use App\Models\ScheduleDelivery;
use App\Models\Stock;
use App\Models\Item;
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
use Filament\Support\Enums\MaxWidth;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Carbon;

class CustomerInvoiceResource extends Resource
{
    protected static ?string $model = CustomerInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Consumer';

    public static function getNavigationSort(): ?int
    {
        return 14;
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
                        Forms\Components\Select::make('customer_order_id')->label('Select Token')->searchable()
                            ->options(CustomerOrder::where('outlet_id',auth()->user()->userEmployee->outlet_id)->where('status','Order Pending')->pluck('token_no','id'))
                            ->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) 
                                {
                                    if ($get('customer_order_id') != null ) 
                                    {
                                        $customerOrder = CustomerOrder::find($get('customer_order_id'));
                                        if($customerOrder->schedule_delivery_id != null)
                                        {
                                            $stock = Stock::where('schedule_delivery_id',$customerOrder->schedule_delivery_id)->count();
                                            if($stock == 0)
                                            {
                                                $delivery = ScheduleDelivery::find($customerOrder->schedule_delivery_id);
                                                if($delivery->status == 'Scheduled')
                                                {
                                                    $fail("The ordered stock is not delivered yet. Please come again after confirmation mail recieved.");
                                                }
                                            }
                                        }
                                    }
                                },
                            ])->live()
                            ->afterStateUpdated(function (Get $get,Set $set)
                            {
                                $customerOrder = CustomerOrder::find($get('customer_order_id'));
                                // dd($customerOrder->customerOrderItem);
                                $set('order_date',$customerOrder->order_date);
                                $set('pickup_date',$customerOrder->pickup_date);
                                $set('item_id',$customerOrder->customerOrderItem->item_id);
                                $set('qty',$customerOrder->customerOrderItem->qty);
                                $set('sales_price',$customerOrder->customerOrderItem->sales_price);
                                $set('total',$customerOrder->customerOrderItem->total);
                            })
                           ,
                        Forms\Components\DatePicker::make('order_date')->readOnly(),
                        Forms\Components\DatePicker::make('pickup_date')->readOnly(),
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
                            ->options(fn (Get $get) => Item::pluck('name','id'))->disabled(),
                        Forms\Components\TextInput::make('qty')->readOnly()
                            ->extraInputAttributes(['style'=>'text-align:right']),
                        Forms\Components\TextInput::make('sales_price')->readOnly()->extraInputAttributes(['style'=>'text-align:right']),
                        Forms\Components\TextInput::make('total')->readOnly()->extraInputAttributes(['style'=>'text-align:right'])
                    ])
                ]),
                Forms\Components\Section::make('')
                ->description('')
                ->schema([
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>3,
                        'lg' => 3,
                    ])
                    ->schema([
 
                        Forms\Components\Toggle::make('is_recieved_empty')->default(true),
                        Forms\Components\TextInput::make('amount')
                            ->extraInputAttributes(['style'=>'text-align:right'])
                            ->numeric()->rules(['required',fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) 
                                {
                                    if ($get('amount') != null ) 
                                    {
                                        if($get('amount') < $get('total'))
                                        {
                                            $fail("Please enter the correct payment amount.");
                                        }
                                    }
                                }
                            ])
                            ->afterStateUpdated(function (Get $get,Set $set)
                            {
                                if ($get('amount') != null ) 
                                {
                                    if($get('amount') >= $get('total'))
                                    {
                                        $set('balance',$get('amount') - $get('total'));
                                    }
                                }
                            })->live(),
                        Forms\Components\TextInput::make('balance')
                            ->extraInputAttributes(['style'=>'text-align:right'])->readOnly()

                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customerInvoiceCity.name_en')
                    ->label('City Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' || auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),
                Tables\Columns\TextColumn::make('customerInvoiceCustomer.mobile_no')
                    ->label('Customer Mobile')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'Customer' ? true : false),

                Tables\Columns\TextColumn::make('token_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_recieved_empty')
                    ->searchable()->boolean(),
                Tables\Columns\TextColumn::make('order_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
                    ->sortable(),
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
                                    fn (Builder $query, $date): Builder => $query->whereDate('invoice_date', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('invoice_date', '<=', $date),
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
                    'Paid' => 'Paid',
                    'Delivered' => 'Delivered'
                ])
                ->label('Status')
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Invoice'),
                Tables\Actions\Action::make('changeStatus')->label('')->icon('heroicon-o-arrow-path')->toolTip('Deliver Stock')
                    ->hidden(fn () : bool => auth()->user()->hasPermissionTo('Update_CustomerInvoice') ? false : true)
                    ->visible(fn (CustomerInvoice $record) : bool => $record->status == 'Delivered' ? false : true)
                    // ->visible(fn (CustomerInvoice $record) : bool => $record->stock_id != null ? true : false)
                    // ->visible(fn (CustomerInvoice $record) : bool => $record->customerInvoiceScheduleDelivery->status == 'Delivered' ? true : false)
                    ->form([
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Delivered'=>'Delivered',
                            ]),
                    ])
                    ->action(function (CustomerInvoice $record, array $data)
                    {
                        
                        $invoiceItem = CustomerInvoiceItem::where('customer_invoice_id',$record->id)->first();
                        if($invoiceItem->schedule_delivery_id != null)
                        {
                            $stock = Stock::where('schedule_delivery_id',$invoiceItem->schedule_delivery_id)->where('item_id',$invoiceItem->item_id)->first();
                            if($stock == null)
                            {
                                Notification::make()
                                    ->warning()
                                    ->title('Warning')
                                    ->body('The Scheduled stock is not delivered yet. Please try again later.')
                                    ->send();
                                return;
                            }
                            else
                            {
                                $stock->qty = $stock->qty - $invoiceItem->qty;
                                $stock->update();
                                $invoiceItem->stock_id = $stock->id;
                                $invoiceItem->update();
                            }
                        }
                        else
                        {
                            $stock = Stock::find($invoiceItem->stock_id);
                            $stock->qty = $stock->qty - $invoiceItem->qty;
                            $stock->update();
                        }

                        $record->status = $data['status'];
                        $record->is_recieved_empty = '1';
                        $record->stock_id = $invoiceItem->stock_id;
                        $record->update();

                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The Invoice item has been delivered to customer successfully.')
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
            'index' => Pages\ListCustomerInvoices::route('/'),
            'create' => Pages\CreateCustomerInvoice::route('/create'),
            // 'edit' => Pages\EditCustomerInvoice::route('/{record}/edit'),
            'view' => Pages\ViewCustomerInvoice::route('/{record}/show'),
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
