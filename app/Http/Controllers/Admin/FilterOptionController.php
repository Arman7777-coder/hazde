<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Http\Request;

class FilterOptionController extends Controller
{
    /**
     * 显示过滤器选项列表
     */
    public function index(Filter $filter)
    {
        $options = $filter->options()->orderBy('sort_order')->get();
        return view('admin.categories.filters.options.index', compact('filter', 'options'));
    }

    /**
     * 显示创建过滤器选项的表单
     */
    public function create(Filter $filter)
    {
        return view('admin.categories.filters.options.create', compact('filter'));
    }

    /**
     * 存储新过滤器选项
     */
    public function store(Request $request, Filter $filter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->only(['name', 'value', 'sort_order']);
        $data['filter_id'] = $filter->id;
        
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

        FilterOption::create($data);

        return redirect()->route('admin.categories.filters.options.index', $filter->id)
            ->with('success', 'Filter option created successfully.');
    }

    /**
     * 显示编辑过滤器选项的表单
     */
    public function edit(Filter $filter, FilterOption $option)
    {
        return view('admin.categories.filters.options.edit', compact('filter', 'option'));
    }

    /**
     * 更新过滤器选项
     */
    public function update(Request $request, Filter $filter, FilterOption $option)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->only(['name', 'value', 'sort_order']);
        
        $option->update($data);

        return redirect()->route('admin.categories.filters.options.index', $filter->id)
            ->with('success', 'Filter option updated successfully.');
    }

    /**
     * 删除过滤器选项
     */
    public function destroy(Filter $filter, FilterOption $option)
    {
        $option->delete();

        return redirect()->route('admin.categories.filters.options.index', $filter->id)
            ->with('success', 'Filter option deleted successfully.');
    }
}