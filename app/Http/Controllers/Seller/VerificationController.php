<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Show the verification request form
     */
    public function showVerificationForm()
    {
        $user = Auth::user();
        
        // Check if user already has a verification request
        $existingVerification = SellerVerification::where('user_id', $user->id)->first();
        
        return view('seller.verification.form', compact('existingVerification'));
    }

    /**
     * Submit a verification request
     */
    public function submitVerification(Request $request)
    {
        $user = Auth::user();
        
        // Check if user already has a pending verification request
        $existingVerification = SellerVerification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existingVerification) {
            return redirect()->back()->with('error', 'У вас уже есть ожидающий проверки запрос на верификацию.');
        }

        $validator = Validator::make($request->all(), [
            'document_type' => 'required|string|in:passport,driver_license,id_card',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:100',
            'document_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'selfie_with_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the uploaded files
        $documentFrontPath = $request->file('document_front')->store('verification_documents', 'public');
        $documentBackPath = null;
        $selfiePath = null;

        if ($request->hasFile('document_back')) {
            $documentBackPath = $request->file('document_back')->store('verification_documents', 'public');
        }

        if ($request->hasFile('selfie_with_document')) {
            $selfiePath = $request->file('selfie_with_document')->store('verification_documents', 'public');
        }

        // Create verification request
        $verification = SellerVerification::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'id_number' => $request->id_number,
            'document_front_path' => $documentFrontPath,
            'document_back_path' => $documentBackPath,
            'selfie_with_document_path' => $selfiePath,
            'status' => 'pending'
        ]);

        return redirect()->route('seller.verification.status')->with('success', 'Ваш запрос на верификацию успешно отправлен. Мы рассмотрим его в ближайшее время.');
    }

    /**
     * Show verification status
     */
    public function showVerificationStatus()
    {
        $user = Auth::user();
        $verification = SellerVerification::where('user_id', $user->id)->latest()->first();
        
        return view('seller.verification.status', compact('verification'));
    }
}