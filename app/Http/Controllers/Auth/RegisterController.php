<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Generate a new random password and update the user
        $password = Str::random(12);
        $user->password = Hash::make($password);
        $user->save();
        
        try {
            \Mail::to($user->email)->send(new \App\Mail\SellerWelcomeMail($user, $password));
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return redirect()->route('login')
            ->with('success', 'Мы отправили учетные данные вашей учетной записи на ваш адрес электронной почты. Пожалуйста, проверьте, чтобы подтвердить, что это ваша учетная запись.');
    }
}
