<?php

namespace App\Http\Controllers\Admin;

use App\Enum\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Http\Request;

class FilterOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:' . PermissionEnum::VIEW_FILTER_OPTIONS->value)->only('index');
        $this->middleware('can:' . PermissionEnum::CREATE_FILTER_OPTION->value)->only('create', 'store');
        $this->middleware('can:' . PermissionEnum::EDIT_FILTER_OPTION->value)->only('edit', 'update');
        $this->middleware('can:' . PermissionEnum::DELETE_FILTER_OPTION->value)->only('destroy');
    }
    /**
     * 显示过滤器选项列表
     */
    public function index($category, Filter $filter)
    {
        $options = $filter->options()->orderBy('sort_order')->get();
        return view('admin.categories.filters.options.index', compact('filter', 'options'));
    }

    /**
     * 显示创建过滤器选项的表单
     */
    public function create($category, Filter $filter)
    {
        return view('admin.categories.filters.options.create', compact('filter'));
    }

    /**
     * 存储新过滤器选项
     */
    public function store(Request $request, $category, Filter $filter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['name', 'value', 'sort_order', 'is_active']);
        $data['filter_id'] = $filter->id;
        
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }
        
        // Ensure is_active always has a value
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        FilterOption::create($data);

        return redirect()->route('admin.categories.filters.options.index', [$category, $filter->id])
            ->with('success', 'Опция фильтра успешно создана.');
    }

    /**
     * 显示编辑过滤器选项的表单
     */
    public function edit($category, Filter $filter, FilterOption $option)
    {
        return view('admin.categories.filters.options.edit', compact('filter', 'option'));
    }

    /**
     * 更新过滤器选项
     */
    public function update(Request $request, $category, Filter $filter, FilterOption $option)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['name', 'value', 'sort_order', 'is_active']);
        
        // Ensure is_active always has a value
        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;
        
        $option->update($data);

        return redirect()->route('admin.categories.filters.options.index', [$category, $filter->id])
            ->with('success', 'Опция фильтра успешно обновлена.');
    }

    /**
     * 删除过滤器选项
     */
    public function destroy($category, Filter $filter, FilterOption $option)
    {
        $option->delete();

        return redirect()->route('admin.categories.filters.options.index', [$category, $filter->id])
            ->with('success', 'Опция фильтра успешно удалена.');
    }
}