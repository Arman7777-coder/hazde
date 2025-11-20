<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductUnavailableDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductUnavailableDateController extends Controller
{
    /**
     * Store unavailable dates for a product
     */
    public function store(Request $request, Product $product)
    {
        // Check if the authenticated user owns this product
        if (Auth::id() !== $product->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'dates' => 'required|array',
            'dates.*' => 'date_format:Y-m-d'
        ]);

        // Delete existing unavailable dates for this product
        ProductUnavailableDate::where('product_id', $product->id)->delete();

        // Add new unavailable dates
        foreach ($request->dates as $date) {
            ProductUnavailableDate::create([
                'product_id' => $product->id,
                'unavailable_date' => $date
            ]);
        }

        return response()->json(['message' => 'Unavailable dates updated successfully']);
    }

    /**
     * Get unavailable dates for a product
     */
    public function show(Product $product)
    {
        $unavailableDates = $product->unavailableDates()
            ->pluck('unavailable_date')
            ->map(function ($date) {
                return $date->format('Y-m-d');
            })
            ->toArray();

        return response()->json($unavailableDates);
    }
}