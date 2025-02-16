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
use App\Filament\Exports\CustomerOrderExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use App\Models\CustomerOrder;

class CustomerOrderReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Report';
    protected static ?string $title = 'Customer Order';
    protected static ?int $navigationSort = 60;
    protected static string $view = 'filament.pages.report.customer-order-report';

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
                ->query(CustomerOrder::query()->where('outlet_id',auth()->user()->userEmployee->outlet_id)->orderBy('order_date','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('token_no')
                        ->searchable()->label('Token'),
                    Tables\Columns\TextColumn::make('no_of_items')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('qty')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('amount')
                        ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
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
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerOrderExporter::class),
                   
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
                ->query(CustomerOrder::query()->orderBy('order_date','desc'))
                ->columns([
                    Tables\Columns\TextColumn::make('customerOrderCity.name_en')
                        ->label('City Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderOutlet.outlet_name')
                        ->label('Outlet Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderCustomer.full_name')
                        ->label('Customer Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('customerOrderCustomer.mobile_no')
                        ->label('Customer Mobile')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('token_no')
                        ->searchable()->label('Token'),
                    Tables\Columns\TextColumn::make('no_of_items')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('qty')
                        ->alignment(Alignment::End)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('amount')
                        ->alignment(Alignment::End)->summarize(Sum::make()->numeric(decimalPlaces: 2,)->label('Total'))
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
                ->headerActions([
                    ExportAction::make('export')->label('Export')
                    ->exporter(CustomerOrderExporter::class),
                   
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
