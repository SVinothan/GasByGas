<?php

namespace App\Filament\Pages\Report;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Exports\CustomerInvoiceExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use App\Models\CustomerInvoice;

class CustomerInvoiceReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $title = 'Customer Invoice';
    protected static ?int $navigationSort = 62;

    protected static string $view = 'filament.pages.report.customer-invoice-report';


    public static function table(Table $table): Table
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return $table
                ->query(CustomerInvoice::query()->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('invoice_date','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerInvoiceCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerInvoiceCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
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
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerInvoiceExporter::class),
                   
                ])
                ->actions([
                    
                ])
                ->bulkActions([
                    // Tables\Actions\BulkActionGroup::make([
                    //     Tables\Actions\DeleteBulkAction::make(),
                    //     Tables\Actions\ForceDeleteBulkAction::make(),
                    //     Tables\Actions\RestoreBulkAction::make(),
                    // ]),
                ]);
            }
            else
            {
                return $table
            ->query(CustomerInvoice::query()->orderBy('invoice_date','desc'))
            ->columns([
                Tables\Columns\TextColumn::make('customerInvoiceCity.name_en')
                    ->label('City Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceOutlet.outlet_name')
                    ->label('Outlet Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceCustomer.full_name')
                    ->label('Customer Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customerInvoiceCustomer.mobile_no')
                    ->label('Customer Mobile')
                    ->searchable(),
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
            ->headerActions([
                ExportAction::make('export')->label('Export')
                ->exporter(CustomerInvoiceExporter::class),
               
            ])
            ->actions([
                
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
            }
    }
}
