<?php

namespace App\Filament\Pages\Profile;

use Filament\Pages\Page;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\BasePage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions;
use App\Models\Province;
use App\Models\District;
use App\Models\City;
use App\Models\Customer;
use Filament\Forms\Get;
use Closure;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;

class Registration extends BaseRegister
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile.registration';
    protected static ?string $title = '';

    // public static function shouldRegisterNavigation(): bool
    // {
    //     return false;
    // }

    public function hasLogo(): bool
    {
        return true;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Personal')
                        ->schema([
                        Forms\Components\Select::make('province_id')->label('Select Province')
                            ->options(Province::pluck('name_en','id'))->rules(['required'])->searchable(),
                        Forms\Components\Select::make('district_id')->label('Select District')
                            ->options(fn (Get $get) => District::where('province_id',$get('province_id'))->pluck('name_en','id'))
                            ->rules(['required'])->searchable(),
                        Forms\Components\Select::make('city_id')->label('Select City')
                            ->options(fn (Get $get) => City::where('district_id',$get('district_id'))->pluck('name_en','id'))
                            ->rules(['required'])->searchable(),
                        Forms\Components\TextInput::make('full_name')->rules(['required'])->regex('/^[a-zA-Z\s]+$/u'),
                        Forms\Components\TextInput::make('nic_no')->rules(['required'])->minLength(10)->maxLength(12)
                            ->unique(table: Customer::class, ignoreRecord:true)->label('NIC Number'),
                    ]),
                    Forms\Components\Wizard\Step::make('Detail')
                        ->schema([
                        Forms\Components\TextInput::make('email')->rules(['required'])->email()
                            ->unique(table: Customer::class, ignoreRecord:true),
                        Forms\Components\TextInput::make('mobile_no')->rules(['required'])->minLength(9)->maxLength(10)
                            ->unique(table: Customer::class, ignoreRecord:true)->label('Mobile Number'),
                        Forms\Components\Textarea::make('address'),
                        Forms\Components\Select::make('type')->label('Select Type')
                            ->options([
                                'Individual' => 'Individual',
                                'Industry' => 'Industry',
                            ])->live()->rules(['required'])->native(false),
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
                        
                    ]),
                    // Forms\Components\Wizard\Step::make('Auth')
                    //     ->schema([
                    //         Forms\Components\TextInput::make('email')->rules(['required'])->email()
                    //             ->unique(table: Customer::class, ignoreRecord:true),
                    //         Forms\Components\TextInput::make('mobile_no')->rules(['required'])->minLength(9)->maxLength(10)
                    //             ->unique(table: Customer::class, ignoreRecord:true)->label('Mobile Number'),
                    //         // $this->getPasswordFormComponent(),
                    //         // $this->getPasswordConfirmationFormComponent(),
                    // ])
            ])->submitAction(new HtmlString(Blade::render(<<<BLADE
            <x-filament::button
                type="submit"
                size="sm" 
                >
            
                Submit
            </x-filament::button>
        BLADE)))
            ])
            
            ->statePath('data')
            ->model(auth()->user());
    }

    public function Submit()
    {
        $data = $this->form->getState();
        $customer = new Customer;
        $customer->province_id = $data['province_id'];
        $customer->district_id = $data['district_id'];
        $customer->city_id = $data['city_id'];
        $customer->full_name = $data['full_name'];
        $customer->address = $data['address'];
        $customer->email = $data['email'];
        $customer->mobile_no = $data['mobile_no'];
        $customer->nic_no = $data['nic_no'];
        $customer->type = $data['type'];
        $customer->status = 'Pending';
        $customer->cylinder_limit = '1';

        if($data['type'] == 'Industry')
        {
            $customer->bussiness_name = $data['bussiness_name'];
            $customer->bussiness_reg_no = $data['bussiness_reg_no'];
            $customer->bussiness_reg_document = $data['bussiness_reg_document'];
            $customer->cylinder_limit = '5';
        }

        $customer->save();

        Notification::make()
            ->success()
            ->title('Succcess')
            ->body('You have been successfully registered. Please check your inbox for  verification email or wait until verification email recieved.')
            ->send();

        return redirect(route('filament.admin.auth.login'));
    }


}
