<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

//add
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\app\Models\User;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

         // Below code is for your customization
         Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->loginname)
            ->orWhere('phone', $request->loginname)
            ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->status == 1) {  // it will return if status == 1
                    return $user;
                }
                throw ValidationException::withMessages(['Tài khoản của bạn đã bị khóa.']);
            }

        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
