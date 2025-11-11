<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function redirectTo(): string
    {
        if (auth()->user()->hasRole('admin')) {
            return RouteServiceProvider::ADMIN;
        } elseif (auth()->user()->hasRole('seller')) {
            // Check if user has selected a plan
            $subscription = auth()->user()->subscription;
            if ($subscription && $subscription->payment_status === 'paid') {
                return RouteServiceProvider::SELLER;
            } else {
                return '/seller/plans/select';
            }
        }
        
        return RouteServiceProvider::HOME;
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign seller role to the new user
        $sellerRole = Role::where('name', 'seller')->first();
        if ($sellerRole) {
            $user->assignRole($sellerRole);
        }

        return $user;
    }
}
