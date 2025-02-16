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
use App\Filament\Exports\CustomerOrderItemExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use App\Models\CustomerOrderItem;

class CustomerOrderItemReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $title = 'Customer Order Item';
    protected static ?int $navigationSort = 61;
    protected static string $view = 'filament.pages.report.customer-order-item-report';

    public static function table(Table $table): Table
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return $table
                ->query(CustomerOrderItem::query()->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('order_date','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderItemCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderDetail.token_no')
                        ->label('Token')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemDetail.name')
                        ->label('Item Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('order_date')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('qty')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('sales_price')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('total')
                        ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
                        ->searchable(),
                    
                ])
                ->filters([
                    Filter::make('order_date')
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
                ])
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerOrderItemExporter::class),
                   
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
                ->query(CustomerOrderItem::query()->orderBy('order_date','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderItemCity.name_en')
                        ->label('City Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemOutlet.outlet_name')
                        ->label('Outlet Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderDetail.token_no')
                        ->label('Token')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderItemDetail.name')
                        ->label('Item Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('order_date')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('qty')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('sales_price')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('total')
                        ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
                        ->searchable(),
                    
                ])
                ->filters([
                    Filter::make('order_date')
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
                ])
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerOrderItemExporter::class),
                   
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
