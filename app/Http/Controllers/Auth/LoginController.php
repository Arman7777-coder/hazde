<?php

namespace App\Http\Controllers\Auth;

use App\Enum\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Check if user has admin role
        if ($user && $user->hasRole(UserRoleEnum::ADMIN->value)) {
            return RouteServiceProvider::ADMIN;
        }
        
        // Check if user has seller role
        if ($user && $user->hasRole(UserRoleEnum::SELLER->value)) {
            return RouteServiceProvider::SELLER;
        }
        
        // Default redirect
        return RouteServiceProvider::HOME;
    }

}
