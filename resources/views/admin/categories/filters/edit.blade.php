@extends('admin.layouts.header-sidebar')

@section('styles')
    <link href="{{asset('admin-src/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
    {{$category->name}} - Edit Filter
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Edit Filter for Category: {{ $category->name }}</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      action="{{route('admin.categories.filters.update', [$category->id, $filter->id])}}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputName" class="form-label">Name *</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Filter Name" value="{{ old('name', $filter->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputTitle" class="form-label">Title *</label>
                                            <input type="text" class="form-control" id="inputTitle" name="title"
                                                   placeholder="Filter Title" value="{{ old('title', $filter->title) }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputSortOrder" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control" id="inputSortOrder" name="sort_order"
                                                   placeholder="0" value="{{ old('sort_order', $filter->sort_order) }}" min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <br>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" 
                                                       id="isActiveSwitch" value="1" {{ old('is_active', $filter->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isActiveSwitch">Active</label>
                                            </div>
                                            @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Update Filter</button>
                                    <a href="{{ route('admin.categories.filters.index', $category->id) }}" class="btn btn-secondary mt-3">Cancel</a>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('admin-src/libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script src="{{asset('admin-src/js/pages/form-advanced.init.js')}}"></script>
@endsection