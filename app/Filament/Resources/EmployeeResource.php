<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use App\Models\Outlet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use Filament\Forms\Get;
use Closure;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationSort(): ?int
    {
        return 25;
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
                        'lg' => 3,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->maxLength(191)->rules(['required'])->regex('/^[a-zA-Z\s]+$/u'),
                        Forms\Components\Select::make('role_id')->searchable()->rules(['required'])->live()
                            ->options(Role::whereNot('name','SuperAdmin')->whereNot('name','Customer')->pluck('name','id'))->label('Select Designation'),
                        Forms\Components\TextInput::make('nic_no')->label('NIC Number')
                            ->minLength(10)->maxLength(12)->unique(table: Employee::class, ignoreRecord:true)->rules(['required']),
                        Forms\Components\TextInput::make('email')
                            ->email()->unique(table: Employee::class, ignoreRecord:true)->rules(['required'])
                            ->maxLength(191),
                        Forms\Components\TextInput::make('mobile_no')->label('Mobile Numbeer')
                            ->numeric()->rules(['required'])->minLength(9)->maxLength(10),
                        Forms\Components\Textarea::make('address')
                    ]),
                    Forms\Components\Grid::make([
                        'sm'=>1,
                        'md'=>2,
                        'lg' => 4,
                    ])
                    ->schema([
                        Forms\Components\Select::make('province_id')->label('Select Province')->rules(['required'])
                            ->options(Province::whereIn('id',Outlet::pluck('province_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('district_id')->label('Select District')->rules(['required'])
                            ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->whereIn('id',Outlet::pluck('district_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('city_id')->label('Select City')->rules(['required'])
                            ->options(fn (Get $get) => City::where('district_id',$get('district_id'))->whereIn('id',Outlet::pluck('city_id'))->pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('outlet_id')->label('Select Outlet')->rules(['required'])
                            ->options(fn (Get $get) => Outlet::where('city_id',$get('city_id'))->pluck('outlet_name','id'))->rules(['required'])->searchable(),
                    ])->hidden(fn (Get $get):bool => $get('role_id') == '2' ? false : true)
                ])
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employeeCity.name_en')
                    ->searchable()->label('City Name'),
                Tables\Columns\TextColumn::make('employeeOutlet.outlet_name')
                    ->searchable()->label('Outlet Name'),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()->label('Employee Name'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_no')
                    ->searchable()->label('Mobile number'),
                Tables\Columns\TextColumn::make('employeeRole.name')
                    ->searchable()->label('Designation'),
                
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->toolTip('View Outlet'),
                Tables\Actions\EditAction::make()->label('')->toolTip('Edit Outlet'),
                Tables\Actions\DeleteAction::make()->label('')->toolTip('Delete Outlet'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
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
