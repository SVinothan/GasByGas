<?php

namespace App\Filament\Pages\Profile;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Actions;
use Filament\Notifications\Notification;
use App\Models\User;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Get;
use Closure;

class UpdateProfileDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile.update-profile-detail';

    
    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        if(auth()->user()->role == 'Customet')
        {
            $this->form->fill(
                auth()->user()->userCustomer->attributesToArray()
            );
        }
        else
        {
            $this->form->fill(
                auth()->user()->userEmployee->attributesToArray()
            );
        }
    }

    public function form(Form $form): Form
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
                        Forms\Components\TextInput::make('nic_no')->label('NIC Number')->hidden(fn():bool=>auth()->user()->role == 'Customer' ? true : false)
                            ->minLength(10)->maxLength(12)->unique(table: Employee::class, ignoreRecord:true)->rules(['required']),
                        Forms\Components\TextInput::make('email')->hidden(fn():bool=>auth()->user()->role == 'Customer' ? true : false)
                            ->email()->unique(table: Employee::class, ignoreRecord:true)->rules(['required'])
                            ->maxLength(191),
                        Forms\Components\TextInput::make('nic_no')->label('NIC Number')->hidden(fn():bool=>auth()->user()->role != 'Customer' ? true : false)
                            ->minLength(10)->maxLength(12)->unique(table: Employee::class, ignoreRecord:true)->rules(['required']),
                        Forms\Components\TextInput::make('email')->hidden(fn():bool=>auth()->user()->role != 'Customer' ? true : false)
                            ->email()->unique(table: Employee::class, ignoreRecord:true)->rules(['required'])
                            ->maxLength(191),
                        Forms\Components\TextInput::make('mobile_no')->label('Mobile Numbeer')
                            ->numeric()->rules(['required'])->minLength(9)->maxLength(10),
                        Forms\Components\Textarea::make('address'),
                        Forms\Components\Select::make('type')->label('Select Type')
                            ->options([
                                'Individual' => 'Individual',
                                'Industry' => 'Industry',
                            ])->live()->rules(['required'])->native(false)->hidden(fn():bool=>auth()->user()->role != 'Customer' ? true : false),
                        Forms\Components\TextInput::make('bussiness_name')
                            ->rules(['required'])->hidden(fn(Get $get):bool=>$get('type') == 'Industry' ? false : true),
                        Forms\Components\TextInput::make('bussiness_reg_no')->label('Registration Number')
                            ->rules(['required'])->hidden(fn(Get $get):bool=>$get('type') == 'Industry' ? false : true),
                        Forms\Components\FileUpload::make('bussiness_reg_document')->label('Registration Document Image')
                            ->rules(['required'])->hidden(fn(Get $get):bool=>$get('type') == 'Industry' ? false : true)
                            ->disk('public')
                            ->directory('customer')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                        Forms\Components\TextInput::make('current_password')
                            ->required()->password() ->autofocus(),
                        Forms\Components\TextInput::make('password')
                            ->required()->password()->minLength(8),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->required()->password()->same('password'),
                    ])
                ])
            ])
            
            ->statePath('data')
            ->model(auth()->user());
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }
    
    public function Update()
    {
        $data = $this->data;
        if ($data['passwordConfirmation'] !== $data['password'] ) 
        {
            Notification::make()
                ->title('Warning!!')
                ->body('Please check your confirm password')
                ->warning()
                ->send();
            return;
        }
        if(auth()->user()->role == 'Customet')
        {
            $customer = Customer::find(auth()->user()->id);
            $customer->full_name = $data['full_name'];
            $customer->nic_no = $data['nic_no'];
            $customer->email = $data['email'];
            $customer->mobile_no = $data['mobile_no'];
            $customer->address = $data['address'];
            $customer->type = $data['type'];
            $customer->bussiness_name = $data['bussiness_name'];
            $customer->bussiness_reg_no = $data['bussiness_reg_no'];
            $customer->bussiness_reg_document = $data['bussiness_reg_document'];
            $customer->update();
        }
        else
        {
            $employee = Employee::find(auth()->user()->employee_id);
            $employee->full_name = $data['full_name'];
            $employee->nic_no = $data['nic_no'];
            $employee->email = $data['email'];
            $employee->mobile_no = $data['mobile_no'];
            $employee->address = $data['address'];
            $employee->update();
        }

        $user = User::find(auth()->user()->id);
        
        if(Hash::check($this->data['current_password'], $user->password))
        {
            $user = User::find(auth()->user()->id);
            $user->name = $data['full_name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->update();

            Notification::make()
            ->title('Profile updated!')
            ->success()
            ->send();
            
            Session::flush();
        
            Auth::logout();
    
            return redirect('/admin/login');
        }
        else
        {
            Notification::make()
            ->title('You entered a wrong password')
            ->warning()
            ->send();
        }
    }
}
