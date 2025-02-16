<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Filament\Support\Enums\MaxWidth;
use Mail;
use App\Mail\SendVerifiedMail;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Consumer';

    public static function getNavigationSort(): ?int
    {
        return 11;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customerProvince.name_en')
                    ->label('Province Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerDistrict.name_en')
                    ->label('District Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('customerCity.name_en')
                    ->label('City Name')
                    ->searchable()
                    ->hidden(fn() : bool=> auth()->user()->getRoleNames()->first() == 'OutletManager' ? true : false),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\Action::make('changeLimit')->label('')->icon('heroicon-o-plus')->toolTip('Change Cylinder Limit')->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('cylinder_limit')->rules(['required'])
                            
                    ])
                    ->action(function(Customer $record, array $data)
                    {
                        $record->cylinder_limit = $data['cylinder_limit'];
                        $record->user_id = auth()->user()->id;
                        $record->update();

                        Notification::make()
                        ->success()
                        ->title('Success')
                        ->body('The Customer limit of cylinder has been updated successfully.')
                        ->send();
                })
                ->modalWidth(MaxWidth::Small),
                Tables\Actions\Action::make('changeStatus')->label('')->icon('heroicon-o-arrow-path')->toolTip('Change Status')
                    ->form([
                        Forms\Components\Select::make('status')->native(false)
                            ->options([
                                'Active'=>'Active',
                                'Deactive'=>'Deactive',
                            ])->native(false)
                    ])
                    ->action(function(Customer $record, array $data)
                    {
                        $record->status = $data['status'];
                        $record->status_by = auth()->user()->id;
                        $record->status_date = Carbon::now()->format('Y-m-d');
                        $record->update();

                        if($data['status'] == 'Active')
                        {
                            if(User::where('customer_id',$record->id)->count() > 0)
                            {
                                $user = User::find($record->user_table_id);
                                $user->is_avtive = '1';
                                $user->save();
                            }
                            else
                            {
                                $user = new User;
                                $user->name = $record->full_name;
                                $user->role = 'Customer';
                                $user->customer_id = $record->id;
                                $user->is_active = '1';
                                $user->email = $record->email;
                                $user->password = bcrypt($record->nic_no);
                                $user->save();

                                $user->assignRole('Customer');

                                $record->user_table_id = $user->id;
                                $record->update();

                                Mail::to($record->email)->send(new SendVerifiedMail([
                                    'title' => 'Your Account Has Been Verified',
                                    'sayHello' => 'Dear '.$record->full_name,
                                    'body' => 'Your account has been verified by Administrator. Now you can make orders for cylinder with us. Your maximum limit of cylinder is one.
                                                If you need more, please contact a outlet manager near you. You can use your email address as user name or email and use your NIC number as password
                                                to login our system.'
                                ]));
                            }
                        }
                        else
                        {
                            if(User::where('customer_id',$record->id)->count() > 0)
                            {
                                $user = User::find($record->user_table_id);
                                $user->is_active = '0';
                                $user->save();
                            }
                        }

                        Notification::make()
                            ->success()
                            ->title('Succcess')
                            ->body('The Customer status has been updated successfully.')
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
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'view' => Pages\ViewCustomer::route('/{record}/show'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->getRoleNames()->first() == 'OutletManager')
        {
            return parent::getEloquentQuery()
            ->where('city_id',auth()->user()->userEmployee->city_id)
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
