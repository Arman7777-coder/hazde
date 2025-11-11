@extends('admin.layouts.header-sidebar')

@section('title', 'Модерация товара')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-3">Модерация товара: {{ $product->name }}</h4>

                                <div class="row">
                                    <!-- Изображения товара -->
                                    <div class="col-lg-6">
                                        @if($product->images->count() > 0)
                                            <div class="bg-light p-3 rounded">
                                                @php
                                                    $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                                                @endphp
                                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $primaryImage->alt_text ?? $product->name }}" class="img-fluid rounded">
                                                
                                                @if($product->images->count() > 1)
                                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                                        @foreach($product->images as $image)
                                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $product->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="bg-light p-5 rounded text-center">
                                                <span class="text-muted">Нет изображений</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Информация о товаре -->
                                    <div class="col-lg-6">
                                        <div class="bg-light p-3 rounded">
                                            <h5 class="mb-3">Информация о товаре</h5>
                                            
                                            <table class="table table-borderless mb-0">
                                                <tr>
                                                    <td><strong>Продавец:</strong></td>
                                                    <td>{{ $product->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email продавца:</strong></td>
                                                    <td>{{ $product->user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Категория:</strong></td>
                                                    <td>{{ $product->category->name ?? 'Не указана' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Цена:</strong></td>
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
                                                </tr>
                                                <tr>
                                                    <td><strong>Дата создания:</strong></td>
                                                    <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Статус:</strong></td>
                                                    <td>
                                                        @if($product->status === 'pending')
                                                            <span class="badge bg-warning">Ожидает модерации</span>
                                                        @elseif($product->status === 'approved')
                                                            <span class="badge bg-success">Одобрен</span>
                                                        @elseif($product->status === 'rejected')
                                                            <span class="badge bg-danger">Отклонен</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Краткое описание -->
                                        @if($product->description)
                                            <div class="bg-light p-3 rounded mt-3">
                                                <h5 class="mb-2">Краткое описание</h5>
                                                <p class="mb-0">{{ $product->description }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Подробное описание -->
                                    @if($product->details)
                                        <div class="col-12 mt-3">
                                            <div class="bg-light p-3 rounded">
                                                <h5 class="mb-2">Подробное описание</h5>
                                                <div>{{ $product->details }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Формы для одобрения или отклонения -->
                                    <div class="col-12 mt-4">
                                        <div class="d-flex gap-2">
                                            <!-- Форма одобрения -->
                                            <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Вы уверены, что хотите одобрить этот товар?')">
                                                    <i class="mdi mdi-check"></i> Одобрить
                                                </button>
                                            </form>

                                            <!-- Форма отклонения -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="mdi mdi-close"></i> Отклонить
                                            </button>

                                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left"></i> Назад
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно отклонения -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Отклонение товара</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Причина отклонения</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Отклонить товар</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection