<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Load related data
        $product->load(['images', 'user', 'filterValues.filter', 'filterValues.filterOption', 'unavailableDates']);
        
        // Get similar products from the same category
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->with('images', 'user')
            ->limit(4)
            ->get();

        return view('client.product', compact('product', 'similarProducts'));
    }
}