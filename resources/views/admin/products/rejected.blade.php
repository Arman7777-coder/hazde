@extends('admin.layouts.header-sidebar')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Отклоненные товары</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                            <i class="fas fa-clock"></i> Товары на модерации
                        </a>
                        <a href="{{ route('admin.products.approved') }}" class="btn btn-success">
                            <i class="fas fa-check"></i> Одобренные товары
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название товара</th>
                                <th>Продавец</th>
                                <th>Категория</th>
                                <th>Цена</th>
                                <th>Причина отказа</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($product->price, 2) }} руб.</td>
                                    <td>{{ $product->rejection_reason ?? 'N/A' }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Просмотр
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Нет отклоненных товаров</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection