@extends('admin.layouts.header-sidebar')
@section('styles')
    <link href="{{asset('admin-src/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('title')
    Categories
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-3">
                                    <a href="{{ route('admin.categories.create')}}"
                                       class="btn btn-primary waves-effect waves-light">Create Category</a>
                                </h4>
                                
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Active</th>
                                        <th>Sort Order</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr id="item-{{$category->id}}">
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->slug}}</td>
                                            <td>{{\Illuminate\Support\Str::limit($category->description, 50)}}</td>
                                            <td>
                                                @if($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="50">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{!! $category->is_active ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>' !!}</td>
                                            <td>{{$category->sort_order}}</td>
                                            <td>{{$category->created_at}}</td>
                                            <td>{{$category->updated_at}}</td>
                                            <td>
                                                <a href="{{route('admin.categories.filters.index', $category->id)}}" class="btn btn-info">
                                                    <span class="mdi mdi-filter"></span> Filters
                                                </a>
                                                <a href="{{route('admin.categories.edit', $category->id)}}" class="btn btn-success">
                                                    <span class="mdi mdi-pencil"></span>
                                                </a>
                                                <a href="javascript:void(0)" data-id="{{$category->id}}" class="btn btn-danger delete" onclick="deleteCategory({{$category->id}})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('admin-src/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admin-src/js/pages/datatables.init.js')}}"></script>
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script>
        function deleteCategory(id) {
            console.log('Delete function called for ID:', id);
            
            // 使用SweetAlert显示确认对话框
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 用户确认删除，发送删除请求
                    const xhr = new XMLHttpRequest();
                    xhr.open('DELETE', `/admin/categories/${id}`, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Accept', 'application/json');
                    
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            console.log('Response status:', xhr.status);
                            if (xhr.status === 200) {
                                try {
                                    const data = JSON.parse(xhr.responseText);
                                    console.log('Response data:', data);
                                    if (data.success) {
                                        // 删除成功，从表格中移除该行
                                        document.getElementById('item-' + id).remove();
                                        // 使用SweetAlert显示成功消息
                                        Swal.fire(
                                            'Deleted!',
                                            'Category has been deleted successfully.',
                                            'success'
                                        );
                                    } else {
                                        // 删除失败，显示错误消息
                                        Swal.fire(
                                            'Error!',
                                            data.message || 'Something went wrong',
                                            'error'
                                        );
                                    }
                                } catch (e) {
                                    console.error('Error parsing JSON:', e);
                                    Swal.fire(
                                        'Error!',
                                        'Error parsing response',
                                        'error'
                                    );
                                }
                            } else {
                                console.error('HTTP Error:', xhr.status, xhr.statusText);
                                Swal.fire(
                                    'Error!',
                                    'HTTP Error: ' + xhr.status,
                                    'error'
                                );
                            }
                        }
                    };
                    
                    xhr.send();
                }
            });
        }
        
        // 为所有删除按钮添加点击事件
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const deleteButtons = document.querySelectorAll('.delete');
            console.log('Found delete buttons:', deleteButtons.length);
            
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    console.log('Button clicked, ID:', id);
                    deleteCategory(id);
                });
            });
        });
    </script>
@endsection