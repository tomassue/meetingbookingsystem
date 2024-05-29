<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //* Added a GLOBAL variable to check if the password is still the default password.
        // I'll use this GLOBAL variable to show an alert message or notice to promptly update the user's password immediately.
        view()->composer('*', function ($view) {
            $user = Auth::user();
            $check_default_password = false;

            if ($user) {
                $check_default_password = Hash::check('password', $user->password);
            }

            $view->with('check_default_password', $check_default_password);
        });
    }
}
