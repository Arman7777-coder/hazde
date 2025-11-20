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
    {{$category->name}} - Фильтры
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
                                    <a href="{{ route('admin.categories.filters.create', $category->id) }}"
                                       class="btn btn-primary waves-effect waves-light">Создать фильтр</a>
                                    <a href="{{ route('admin.categories.index') }}"
                                       class="btn btn-secondary waves-effect waves-light">Вернуться к категориям</a>
                                </h4>
                                
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Заголовок</th>
                                        <th>Порядок сортировки</th>
                                        <th>Статус</th>
                                        <th>Создан</th>
                                        <th>Обновлен</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($filters as $filter)
                                        <tr id="item-{{$filter->id}}">
                                            <td>{{$filter->id}}</td>
                                            <td>{{$filter->name}}</td>
                                            <td>{{$filter->title}}</td>
                                            <td>{{$filter->sort_order}}</td>
                                            <td>{!! $filter->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                            <td>{{$filter->created_at}}</td>
                                            <td>{{$filter->updated_at}}</td>
                                            <td>
                                                <a href="{{route('admin.categories.filters.options.index', [$category->id, $filter->id])}}" class="btn btn-info">
                                                    <span class="mdi mdi-filter-plus"></span> Options
                                                </a>
                                                <a href="{{route('admin.categories.filters.edit', [$category->id, $filter->id])}}" class="btn btn-success">
                                                    <span class="mdi mdi-pencil"></span>
                                                </a>
                                                <a href="javascript:void(0)" data-id="{{$filter->id}}" data-category="{{$category->id}}" class="btn btn-danger delete" onclick="deleteFilter({{$category->id}}, {{$filter->id}})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                
                                @if($filters->count() == 0)
                                    <div class="alert alert-info">
                                        Фильтры для этой категории не найдены.
                                    </div>
                                @endif

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
        function deleteFilter(categoryId, id) {
            console.log('Delete function called for filter ID:', id);
            
            // 使用SweetAlert显示确认对话框
            Swal.fire({
                title: 'Вы уверены?',
                text: "Вы не сможете отменить это действие!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да, удалить!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 用户确认删除，发送删除请求
                    const xhr = new XMLHttpRequest();
                    xhr.open('DELETE', `/admin/categories/${categoryId}/filters/${id}`, true);
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
                                            'Удалено!',
                                            'Фильтр успешно удален.',
                                            'success'
                                        );
                                    } else {
                                        // 删除失败，显示错误消息
                                        Swal.fire(
                                            'Ошибка!',
                                            data.message || 'Что-то пошло не так',
                                            'error'
                                        );
                                    }
                                } catch (e) {
                                    console.error('Error parsing JSON:', e);
                                    Swal.fire(
                                        'Ошибка!',
                                        'Ошибка разбора ответа',
                                        'error'
                                    );
                                }
                            } else {
                                console.error('HTTP Error:', xhr.status, xhr.statusText);
                                Swal.fire(
                                    'Ошибка!',
                                    'HTTP ошибка: ' + xhr.status,
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
                    const categoryId = this.getAttribute('data-category');
                    const id = this.getAttribute('data-id');
                    console.log('Button clicked, Category ID:', categoryId, 'Filter ID:', id);
                    deleteFilter(categoryId, id);
                });
            });
        });
    </script>
@endsection