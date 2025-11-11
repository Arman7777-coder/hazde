<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * 显示成为卖家页面
     */
    public function index()
    {
        return view('client.seller');
    }
}