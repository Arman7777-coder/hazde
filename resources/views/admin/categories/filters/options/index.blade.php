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
    {{$filter->name}} - Опции
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
                                    <a href="{{ route('admin.categories.filters.options.create', [$filter->category_id, $filter->id]) }}"
                                       class="btn btn-primary waves-effect waves-light">Добавить опцию</a>
                                    <a href="{{ route('admin.categories.filters.index', $filter->category_id) }}"
                                       class="btn btn-secondary waves-effect waves-light">Вернуться к фильтрам</a>
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
                                        <th>Значение</th>
                                        <th>Порядок сортировки</th>
                                        <th>Статус</th>
                                        <th>Создан</th>
                                        <th>Обновлен</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($options as $option)
                                        <tr id="item-{{$option->id}}">
                                            <td>{{$option->id}}</td>
                                            <td>{{$option->name}}</td>
                                            <td>{{$option->value}}</td>
                                            <td>{{$option->sort_order}}</td>
                                            <td>{!! $option->is_active ? '<span class="badge bg-success">Активный</span>' : '<span class="badge bg-secondary">Неактивный</span>' !!}</td>
                                            <td>{{$option->created_at}}</td>
                                            <td>{{$option->updated_at}}</td>
                                            <td>
                                                <a href="{{route('admin.categories.filters.options.edit', [$filter->category_id, $filter->id, $option->id])}}" class="btn btn-success">
                                                    <span class="mdi mdi-pencil"></span>
                                                </a>
                                                <a href="javascript:void(0)" data-id="{{$option->id}}" data-filter="{{$filter->id}}" data-category="{{$filter->category_id}}" class="btn btn-danger delete-option">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Опции отсутствуют</td>
                                        </tr>
                                    @endforelse
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
        // Delete option function
        function deleteOption(categoryId, filterId, id) {
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
                    const xhr = new XMLHttpRequest();
                    xhr.open('DELETE', `/admin/categories/${categoryId}/filters/${filterId}/options/${id}`, true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Accept', 'application/json');
                    
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                try {
                                    const data = JSON.parse(xhr.responseText);
                                    if (data.success) {
                                        document.getElementById('item-' + id).remove();
                                        Swal.fire(
                                            'Удалено!',
                                            'Опция успешно удалена.',
                                            'success'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Ошибка!',
                                            data.message || 'Что-то пошло не так',
                                            'error'
                                        );
                                    }
                                } catch (e) {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Ошибка разбора ответа',
                                        'error'
                                    );
                                }
                            } else {
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
        
        // Add event listeners to delete buttons
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-option');
            
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-category');
                    const filterId = this.getAttribute('data-filter');
                    const id = this.getAttribute('data-id');
                    deleteOption(categoryId, filterId, id);
                });
            });
        });
    </script>
@endsection