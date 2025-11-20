<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLike;
use Illuminate\Http\Request;

class ProductLikeController extends Controller
{
    public function toggleLike(Request $request, $productId)
    {
        // Find the product by ID
        $product = Product::findOrFail($productId);
        
        $ipAddress = $request->ip();
        
        $like = ProductLike::where('product_id', $product->id)
                          ->where('ip_address', $ipAddress)
                          ->first();
        
        if ($like) {
            // Unlike the product
            $like->delete();
            $liked = false;
        } else {
            // Like the product
            ProductLike::create([
                'product_id' => $product->id,
                'ip_address' => $ipAddress
            ]);
            $liked = true;
        }
        
        // Get updated like count
        $likeCount = $product->likes()->count();
        
        return response()->json([
            'liked' => $liked,
            'like_count' => $likeCount
        ]);
    }
    
    public function likedProducts()
    {
        $ipAddress = request()->ip();
        $likedProducts = ProductLike::where('ip_address', $ipAddress)
                                   ->with('product.images', 'product.user')
                                   ->paginate(12);
        
        // Check if products are liked by current user (for consistency)
        $likedProductIds = ProductLike::where('ip_address', $ipAddress)
                                   ->pluck('product_id')
                                   ->toArray();

        return view('client.liked-products', compact('likedProducts', 'likedProductIds'));
    }
}