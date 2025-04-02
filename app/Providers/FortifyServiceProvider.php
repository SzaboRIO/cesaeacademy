<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Definir as views de login e registro
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        // Evento de login bem-sucedido
        Event::listen(Login::class, function ($event) {
            // Verifica se o usuário acabou de se registrar
            if (session()->has('just_registered')) {
                // Remove a flag, mas mantém a mensagem de registo
                session()->forget('just_registered');
            } else {
                // Usuário fez login normal (não após registro)
                session()->flash('success', 'Login efetuado com sucesso!');
            }
        });

        // Evento de falha no login
        Event::listen(Failed::class, function ($event) {
            session()->flash('error', 'Email ou senha incorretos.');
        });

        // Evento de registo bem-sucedido
        Event::listen(Registered::class, function ($event) {
            session()->flash('success', 'Conta criada com sucesso!');

            // Define uma flag para indicar que o usuário acabou de se registrar
            session()->put('just_registered', true);
        });

        // Evento de redefinição de senha
        Event::listen(PasswordReset::class, function ($event) {
            session()->flash('success', 'Senha redefinida com sucesso!');
        });
    }
}
