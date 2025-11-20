<?php

namespace App\Http\Controllers;

use App\Models\SellerPlan;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * 显示成为卖家页面
     */
    public function index()
    {
        $plans = SellerPlan::all();
        return view('client.seller', compact('plans'));
    }
}