<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:' . PermissionEnum::VIEW_PRODUCTS->value)->only('index', 'show', 'approved', 'rejected');
        $this->middleware('can:' . PermissionEnum::APPROVE_PRODUCT->value)->only('approve');
        $this->middleware('can:' . PermissionEnum::REJECT_PRODUCT->value)->only('reject');
    }
    /**
     * 显示待审批的产品列表
     */
    public function index()
    {
        $products = Product::with('user', 'category')
            ->where('status', 'pending')
            ->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * 显示产品详情（审批页面）
     */
    public function show(Product $product)
    {
        // 确保产品处于待审批状态
        if ($product->status !== 'pending') {
            return redirect()->route('admin.products.index')->with('error', 'Товар не находится на модерации.');
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * 批准产品
     */
    public function approve(Request $request, Product $product)
    {
        // 确保产品处于待审批状态
        if ($product->status !== 'pending') {
            return redirect()->route('admin.products.index')->with('error', 'Товар не находится на модерации.');
        }

        $product->update([
            'status' => 'approved',
            'is_active' => true,
            'rejection_reason' => null
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар успешно одобрен и опубликован.');
    }

    /**
     * 拒绝产品
     */
    public function reject(Request $request, Product $product)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        // 确保产品处于待审批状态
        if ($product->status !== 'pending') {
            return redirect()->route('admin.products.index')->with('error', 'Товар не находится на модерации.');
        }

        $product->update([
            'status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар отклонен с причиной: ' . $request->rejection_reason);
    }

    /**
     * 显示已批准的产品列表
     */
    public function approved()
    {
        $products = Product::with('user', 'category')
            ->where('status', 'approved')
            ->paginate(10);
        
        return view('admin.products.approved', compact('products'));
    }

    /**
     * 显示被拒绝的产品列表
     */
    public function rejected()
    {
        $products = Product::with('user', 'category')
            ->where('status', 'rejected')
            ->paginate(10);
        
        return view('admin.products.rejected', compact('products'));
    }
}