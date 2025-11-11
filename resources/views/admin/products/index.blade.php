@extends('admin.layouts.header-sidebar')

@section('title', 'Товары на модерации')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Товары на модерации</h4>

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if($products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Название</th>
                                                    <th>Продавец</th>
                                                    <th>Категория</th>
                                                    <th>Цена</th>
                                                    <th>Дата создания</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->user->name }}</td>
                                                        <td>{{ $product->category->name ?? 'Не указана' }}</td>
                                                        <td>
                                                            @if($product->price)
                                                                {{ number_format($product->price, 0, ',', ' ') }} руб.
                                                                @if($product->price_type === 'hourly')
                                                                    / час
                                                                @endif
                                                            @else
                                                                Не указана
                                                            @endif
                                                        </td>
                                                        <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm">
                                                                <i class="mdi mdi-eye"></i> Просмотр
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4">
                                        {{ $products->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-muted">Нет товаров на модерации</p>
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