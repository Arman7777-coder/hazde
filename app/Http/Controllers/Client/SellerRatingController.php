<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SellerRatingController extends Controller
{
    /**
     * Store a new rating for a seller
     *
     * @param Request $request
     * @param int $sellerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $sellerId)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if seller exists
        $seller = User::find($sellerId);
        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller not found'
            ], 404);
        }

        // Check if user is trying to rate themselves
        if (Auth::check() && Auth::id() == $sellerId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot rate yourself'
            ], 400);
        }

        // Check if user already rated this seller
        $existingRating = SellerRating::where('user_id', Auth::id())
                                     ->where('seller_id', $sellerId)
                                     ->first();
        
        if ($existingRating) {
            return response()->json([
                'success' => false,
                'message' => 'You have already rated this seller'
            ], 400);
        }

        // Create the rating
        $rating = new SellerRating();
        $rating->user_id = Auth::id();
        $rating->seller_id = $sellerId;
        $rating->rating = $request->rating;
        $rating->save();

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully',
            'data' => [
                'average_rating' => $seller->fresh()->average_rating,
                'total_ratings' => $seller->fresh()->total_ratings
            ]
        ]);
    }

    /**
     * Get seller rating information
     *
     * @param int $sellerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($sellerId)
    {
        $seller = User::find($sellerId);
        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller not found'
            ], 404);
        }

        // Get ratings for the seller with user information
        $ratings = SellerRating::where('seller_id', $sellerId)
                              ->with('user')
                              ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'average_rating' => $seller->average_rating,
                'total_ratings' => $seller->total_ratings,
                'ratings' => $ratings
            ]
        ]);
    }
}