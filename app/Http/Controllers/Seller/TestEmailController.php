<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\SellerWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TestEmailController extends Controller
{
    /**
     * Send a test email
     */
    public function sendTestEmail(Request $request)
    {
        try {
            // Create a test user
            $password = Str::random(12);
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test_' . time() . '@example.com',
                'password' => Hash::make($password),
                'phone_number' => '1234567890'
            ]);
            
            // Send welcome email
            Mail::to($user->email)->send(new SellerWelcomeMail($user, $password));
            
            // Clean up test user
            $user->delete();
            
            return response()->json(['status' => 'success', 'message' => 'Test email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}