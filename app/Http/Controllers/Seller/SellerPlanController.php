<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerPlan;
use Illuminate\Http\Request;

class SellerPlanController extends Controller
{
    /**
     * 显示所有套餐计划
     */
    public function index()
    {
        $plans = SellerPlan::all();
        return view('seller.plans.index', compact('plans'));
    }

    /**
     * 显示选择套餐页面
     */
    public function selectPlan()
    {
        $plans = SellerPlan::all();
        return view('seller.plans.select', compact('plans'));
    }

    /**
     * API: 获取套餐详情
     */
    public function show(SellerPlan $plan)
    {
        return response()->json($plan);
    }
}