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
use App\Filament\Exports\CustomerInvoiceItemExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use App\Models\CustomerInvoiceItem;

class CustomerInvoiceItemReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $title = 'Customer Invoice Item';
    protected static ?int $navigationSort = 63;

    protected static string $view = 'filament.pages.report.customer-invoice-item-report';

    public static function canAccess(): bool
    {
        if(auth()->user()->getRoleNames()->first() == 'Customer' || auth()->user()->getRoleNames()->first() == 'DispatchOfficer')
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public static function table(Table $table): Table
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return $table
                ->query(CustomerInvoiceItem::query()->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('updated_at','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerInvoiceDetail.token_no')
                        ->label('Token')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerInvoiceItemDetail.name')
                        ->label('Item Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('qty')
                    ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total Qty'))
                    ->searchable(),
                    Tables\Columns\TextColumn::make('amount')
                    ->alignment(Alignment::End)
                    ->searchable(),
                    Tables\Columns\TextColumn::make('total')
                    ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
                    ->searchable(),
                    
                ])
                ->filters([
                    Filter::make('updated_at')
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
                                fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '<=', $date),
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
                ])
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerInvoiceItemExporter::class),
                   
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
            else
            {
                return $table
                    ->query(CustomerInvoiceItem::query()->orderBy('updated_at','desc'))
                    ->columns([
                        Tables\Columns\TextColumn::make('customerInvoiceItemCity.name_en')
                            ->label('City Name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('customerInvoiceItemOutlet.outlet_name')
                            ->label('Outlet Name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.full_name')
                            ->label('Customer Name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('customerInvoiceItemCustomer.mobile_no')
                            ->label('Customer Mobile')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('customerInvoiceDetail.token_no')
                            ->label('Token')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('customerInvoiceItemDetail.name')
                            ->label('Item Name')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('qty')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('amount')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('total')
                            ->searchable(),
                        
                    ])
                    ->filters([
                        Filter::make('updated_at')
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
                                    fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'] ?? null,
                                    fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '<=', $date),
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
                    ])
                    ->headerActions([
                        ExportAction::make('export')->label('Export')
                        ->exporter(CustomerInvoiceItemExporter::class),
                       
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
        }
}
