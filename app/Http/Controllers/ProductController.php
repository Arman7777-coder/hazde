<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Ensure the product is approved and active
        if ($product->status !== 'approved' || !$product->is_active) {
            abort(404, 'Product not found');
        }

        // Load related data
        $product->load(['user', 'category', 'images']);
        
        // Get similar products (same category, approved and active, limit 4)
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->with(['images', 'user'])
            ->limit(4)
            ->get();

        return view('client.product', compact('product', 'similarProducts'));
    }
}