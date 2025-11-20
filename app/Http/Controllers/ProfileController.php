<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repository\TransactionsRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function App\Helpers\getAuthUser;

final class ProfileController extends Controller
{
    public function __construct(
        private readonly TransactionsRepositoryInterface $transactionRepo
    )
    {}

    /**
     * @throws \Exception
     */
    public function profile(): View|Application|Factory
    {
        $user = getAuthUser();
        $isPaid = $this->transactionRepo->getUserPaidStatus($user->id);
        return view('profile',compact('user','isPaid'));
    }

    /**
     * Show the form for editing the user profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        if (isset($validated['phone_number'])) {
            $user->phone_number = $validated['phone_number'];
        }
        
        if (isset($validated['company_name'])) {
            $user->company_name = $validated['company_name'];
        }
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = 'storage/' . $avatarPath;
        }
        
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Профиль успешно обновлен!');
    }
}