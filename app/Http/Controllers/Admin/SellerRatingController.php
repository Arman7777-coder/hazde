<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SellerRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:' . PermissionEnum::VIEW_SELLER_RATINGS->value)->only(['index']);
        $this->middleware('permission:' . PermissionEnum::CREATE_SELLER_RATING->value)->only(['create', 'store']);
        $this->middleware('permission:' . PermissionEnum::EDIT_SELLER_RATING->value)->only(['edit', 'update']);
        $this->middleware('permission:' . PermissionEnum::DELETE_SELLER_RATING->value)->only(['destroy']);
    }

    /**
     * Display a listing of seller ratings.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $ratings = SellerRating::with(['admin', 'seller'])->latest()->paginate(20);
        return view('admin.seller-ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new seller rating.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // Let's try a different approach to see what we get
        $allSellers = User::all();
        $verifiedSellers = User::where('is_verified_seller', true)->get();
        $verifiedSellersCount = User::where('is_verified_seller', true)->count();
        
        \Log::info('All users count: ' . $allSellers->count());
        \Log::info('Verified sellers count: ' . $verifiedSellersCount);
        
        // Let's also check what the is_verified_seller field contains
        foreach($allSellers as $user) {
            \Log::info('User: ' . $user->name . ', is_verified_seller: ' . ($user->is_verified_seller ? 'true' : 'false') . ', type: ' . gettype($user->is_verified_seller));
        }
        
        $sellers = $verifiedSellers;
        
        return view('admin.seller-ratings.create', compact('sellers'));
    }

    /**
     * Store a newly created seller rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if rating already exists for this seller
        $existingRating = SellerRating::where('seller_id', $request->seller_id)->first();
        
        if ($existingRating) {
            return redirect()->back()->withErrors(['error' => 'This seller already has a rating. You can edit the existing rating.'])->withInput();
        }

        SellerRating::create([
            'admin_id' => Auth::id(),
            'seller_id' => $request->seller_id,
            'rating' => $request->rating,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.seller-ratings.index')->with('success', 'Seller rating created successfully.');
    }

    /**
     * Show the form for editing the specified seller rating.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $rating = SellerRating::findOrFail($id);
        $sellers = User::where('is_verified_seller', true)->get();
        
        // Debug information
        \Log::info('Sellers count in edit: ' . $sellers->count());
        
        return view('admin.seller-ratings.edit', compact('rating', 'sellers'));
    }

    /**
     * Update the specified seller rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $rating = SellerRating::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if another rating exists for the same seller (but not this one)
        $existingRating = SellerRating::where('seller_id', $request->seller_id)
                                    ->where('id', '!=', $id)
                                    ->first();
        
        if ($existingRating) {
            return redirect()->back()->withErrors(['error' => 'This seller already has a rating. Each seller can only have one rating.'])->withInput();
        }

        $rating->update([
            'admin_id' => Auth::id(),
            'seller_id' => $request->seller_id,
            'rating' => $request->rating,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.seller-ratings.index')->with('success', 'Seller rating updated successfully.');
    }

    /**
     * Remove the specified seller rating from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $rating = SellerRating::findOrFail($id);
        $rating->delete();

        return redirect()->route('admin.seller-ratings.index')->with('success', 'Seller rating deleted successfully.');
    }
}