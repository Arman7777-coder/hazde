@extends('seller.layouts.header-sidebar')
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
    Товары
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
                                    <a href="{{ route('seller.products.create')}}"
                                       class="btn btn-primary waves-effect waves-light">Создать товар</a>
                                </h4>
                                
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Категория</th>
                                        <th>Цена</th>
                                        <th>Статус</th>
                                        <th>Создан</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($products as $product)
                                        <tr id="item-{{$product->id}}">
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->category->name ?? 'Н/Д'}}</td>
                                            <td>{{$product->price ?? 'Не установлена'}}</td>
                                            <td>
                                                @if($product->status == 'pending')
                                                    <span class="badge bg-warning">На рассмотрении</span>
                                                @elseif($product->status == 'approved')
                                                    <span class="badge bg-success">Одобрен</span>
                                                @elseif($product->status == 'rejected')
                                                    <span class="badge bg-danger">Отклонен</span>
                                                @endif
                                            </td>
                                            <td>{{$product->created_at}}</td>
                                            <td>
                                                <a href="{{route('seller.products.show', $product->id)}}" class="btn btn-info">
                                                    <span class="mdi mdi-eye"></span>
                                                </a>
                                                <a href="{{route('seller.products.edit', $product->id)}}" class="btn btn-success">
                                                    <span class="mdi mdi-pencil"></span>
                                                </a>
                                                <a href="javascript:void(0)" data-id="{{$product->id}}" class="btn btn-danger delete" onclick="deleteProduct({{$product->id}})">
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
        function deleteProduct(id) {
            console.log('Delete function called for ID:', id);
            
            // 使用SweetAlert显示确认对话框
            Swal.fire({
                title: 'Вы уверены?',
                text: "Вы не сможете отменить это действие!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да, удалить!',
                cancelButtonText: 'Отмена'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 用户确认删除，发送删除请求
                    const xhr = new XMLHttpRequest();
                    xhr.open('DELETE', `/seller/products/${id}`, true);
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
                                            'Товар успешно удален.',
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
                                        'Ошибка обработки ответа',
                                        'error'
                                        );
                                }
                            } else {
                                console.error('HTTP Error:', xhr.status, xhr.statusText);
                                Swal.fire(
                                    'Ошибка!',
                                    'Ошибка HTTP: ' + xhr.status,
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
                    deleteProduct(id);
                });
            });
        });
    </script>
@endsection