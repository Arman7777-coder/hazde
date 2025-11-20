@extends('admin.layouts.header-sidebar')

@section('title')
    {{$filter->name}} - Редактировать опцию
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Редактировать опцию для фильтра: {{ $filter->name }}</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      action="{{route('admin.categories.filters.options.update', [$filter->category_id, $filter->id, $option->id])}}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputName" class="form-label">Название *</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Название опции" value="{{ old('name', $option->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputValue" class="form-label">Значение *</label>
                                            <input type="text" class="form-control" id="inputValue" name="value"
                                                   placeholder="Значение опции" value="{{ old('value', $option->value) }}" required>
                                            @error('value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputSortOrder" class="form-label">Порядок сортировки</label>
                                            <input type="number" class="form-control" id="inputSortOrder" name="sort_order"
                                                   placeholder="0" value="{{ old('sort_order', $option->sort_order) }}" min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Статус</label>
                                            <br>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" 
                                                       id="isActiveSwitch" value="1" {{ old('is_active', $option->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isActiveSwitch">Активный</label>
                                            </div>
                                            @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Обновить опцию</button>
                                    <a href="{{ route('admin.categories.filters.options.index', [$filter->category_id, $filter->id]) }}" class="btn btn-secondary mt-3">Отмена</a>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection