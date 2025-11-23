<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerVerification;
use App\Models\User;
use Illuminate\Http\Request;

class SellerVerificationController extends Controller
{
    /**
     * Display a listing of pending verification requests
     */
    public function index()
    {
        $verifications = SellerVerification::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.seller-verifications.index', compact('verifications'));
    }

    /**
     * Display the specified verification request
     */
    public function show($id)
    {
        $verification = SellerVerification::with('user')->findOrFail($id);
        return view('admin.seller-verifications.show', compact('verification'));
    }

    /**
     * Approve a verification request
     */
    public function approve(Request $request, $id)
    {
        $verification = SellerVerification::with('user')->findOrFail($id);
        
        $verification->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'verified_at' => now()
        ]);

        // Update user as verified
        if ($verification->user) {
            // Directly update the user instead of using the relationship
            $user = User::find($verification->user_id);
            if ($user) {
                $user->update([
                    'is_verified_seller' => true,
                    'seller_verified_at' => now()
                ]);
            }
        }

        return redirect()->route('admin.seller-verifications.index')
            ->with('success', 'Запрос на верификацию успешно одобрен.');
    }

    /**
     * Reject a verification request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $verification = SellerVerification::with('user')->findOrFail($id);
        
        $verification->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.seller-verifications.index')
            ->with('success', 'Запрос на верификацию отклонен.');
    }
}