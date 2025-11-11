@extends('admin.layouts.header-sidebar')
@section('styles')
    <link href="{{asset('admin-src/libs/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
    Categories create
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Create Category</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      enctype="multipart/form-data"
                                      action="{{route('admin.categories.store')}}">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputName" class="form-label">Name *</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Category Name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="inputDescription" name="description" 
                                                      rows="4" placeholder="Category Description"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputImage" class="form-label">Category Image</label>
                                            <input type="file" id="inputImage" name="image" 
                                                   data-plugins="dropify" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputSortOrder" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control" id="inputSortOrder" name="sort_order"
                                                   placeholder="0" value="0">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <br>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active" 
                                                       id="isActiveSwitch" value="1" checked>
                                                <label class="form-check-label" for="isActiveSwitch">Active</label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Create Category</button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Cancel</a>
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
    <script src="{{asset('admin-src/libs/selectize/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('admin-src/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('admin-src/js/pages/form-advanced.init.js')}}"></script>
@endsection