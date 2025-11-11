<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:' . PermissionEnum::VIEW_FILTERS->value)->only('index');
        $this->middleware('can:' . PermissionEnum::CREATE_FILTER->value)->only('create', 'store');
        $this->middleware('can:' . PermissionEnum::EDIT_FILTER->value)->only('edit', 'update');
        $this->middleware('can:' . PermissionEnum::DELETE_FILTER->value)->only('destroy');
    }

    /**
     * 显示分类的过滤器列表
     */
    public function index(Category $category)
    {
        $filters = $category->filters()->orderBy('sort_order')->get();
        return view('admin.categories.filters.index', compact('category', 'filters'));
    }

    /**
     * 显示创建过滤器的表单
     */
    public function create(Category $category)
    {
        return view('admin.categories.filters.create', compact('category'));
    }

    /**
     * 存储新过滤器
     */
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['name', 'title', 'sort_order', 'is_active']);
        $data['category_id'] = $category->id;
        
        // Ensure is_active always has a value
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        $filter = Filter::create($data);

        return redirect()->route('admin.categories.filters.index', $category->id)
            ->with('success', 'Filter created successfully.');
    }

    /**
     * 显示编辑过滤器的表单
     */
    public function edit(Category $category, Filter $filter)
    {
        return view('admin.categories.filters.edit', compact('category', 'filter'));
    }

    /**
     * 更新过滤器
     */
    public function update(Request $request, Category $category, Filter $filter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['name', 'title', 'sort_order', 'is_active']);
        
        // Ensure is_active always has a value
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : true;
        
        $filter->update($data);

        return redirect()->route('admin.categories.filters.index', [$category->id])
            ->with('success', 'Filter updated successfully.');
    }

    /**
     * 删除过滤器
     */
    public function destroy(Category $category, Filter $filter)
    {
        // Check if filter has options
        if ($filter->options()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete filter with options. Please delete options first.'
            ]);
        }

        $filter->delete();

        return response()->json([
            'success' => true,
            'message' => 'Filter deleted successfully.'
        ]);
    }
}