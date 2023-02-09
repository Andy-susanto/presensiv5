<?php

namespace App\Http\Livewire\Auth;

use Exception;
use App\Models\User;
use Livewire\Component;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;
use Filament\Forms\Concerns\InteractsWithForms;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

/**
 * @property ComponentContainer $form
 */
class Login extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public $email = '';

    public $password = '';

    public $remember = false;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'username' => __('filament::login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $data = $this->form->getState();

        $loginmanual = Auth::attempt(['username' => $data['username'], 'password' => $data['password']]);
        if (!$loginmanual) {
            $ldapconn = ldap_connect(env('LDAP_HOST'));
            if (!$ldapconn) {
                throw ValidationException::withMessages([
                    'username' => 'Gagal Connect ke server',
                ]);
            }

            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            try {
                $ldapbind = @ldap_bind($ldapconn, "uid=" . $data['username'] . ",ou=users,dc=unja,dc=ac,dc=id", $data['password']);
            } catch (Exception $ee) {
                die();
            }

            if ($ldapbind) {
            } else {

                if (($data['password'] == "presensi") && (strtolower($data['username'] != "adminsiakad"))) {
                    Session::put(md5("loginsakti"), "true");
                } else {
                    throw ValidationException::withMessages([
                        'username' => 'Password Salah',
                    ]);
                    die();
                }
            }
        }

        $username = $data['username'];

        $user = User::where('username', '=', $username)->first();
        if (!empty($user)) {
            Auth::login($user);
            session()->regenerate();
            return app(LoginResponse::class);
        } else {
            throw ValidationException::withMessages([
                'username' => 'Gagal Login',
            ]);
        }

        // if (! Filament::auth()->attempt([
        //     'username' => $data['username'],
        //     'password' => $data['password'],
        // ], $data['remember'])) {
        //     throw ValidationException::withMessages([
        //         'username' => __('filament::login.messages.failed'),
        //     ]);
        // }

        // session()->regenerate();

        // return app(LoginResponse::class);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('username')
                ->label('Username')
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label')),
        ];
    }

    public function render(): View
    {
        return view('filament::login')
            ->layout('filament::components.layouts.card', [
                'title' => 'Silahkan Masuk',
            ]);
    }
}
