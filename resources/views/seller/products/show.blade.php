@extends('seller.layouts.header-sidebar')

@section('title')
    Детали товара
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Детали товара</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Основная информация</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Название:</strong></td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Категория:</strong></td>
                                                <td>{{ $product->category->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Цена:</strong></td>
                                                <td>{{ $product->price ?? 'Не установлена' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Тип цены:</strong></td>
                                                <td>{{ ucfirst($product->price_type) == 'Fixed' ? 'Фиксированная' : 'Почасовая' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Статус:</strong></td>
                                                <td>
                                                    @if($product->status == 'pending')
                                                        <span class="badge bg-warning">На рассмотрении</span>
                                                    @elseif($product->status == 'approved')
                                                        <span class="badge bg-success">Одобрен</span>
                                                    @elseif($product->status == 'rejected')
                                                        <span class="badge bg-danger">Отклонен</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h5>Значения фильтров</h5>
                                        @if($product->filterValues->count() > 0)
                                            <table class="table table-borderless">
                                                @foreach($product->filterValues as $filterValue)
                                                    <tr>
                                                        <td><strong>{{ $filterValue->filter->title ?? $filterValue->filter->name }}:</strong></td>
                                                        <td>
                                                            @if($filterValue->filterOption)
                                                                {{ $filterValue->filterOption->name }}
                                                            @else
                                                                {{ $filterValue->value }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                            <p>Для этого товара не установлены значения фильтров.</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Описание</h5>
                                        <p>{{ $product->description ?? 'Описание отсутствует.' }}</p>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Детали</h5>
                                        <p>{{ $product->details ?? 'Детали отсутствуют.' }}</p>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Изображения</h5>
                                        @if($product->images->count() > 0)
                                            <div class="row">
                                                @foreach($product->images as $image)
                                                    <div class="col-md-3 mb-3">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>Для этого товара нет изображений.</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Display PDF document if exists -->
                                @if($product->pdf_document_path)
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>PDF документ</h5>
                                        <p>
                                            <a href="{{ asset('storage/' . $product->pdf_document_path) }}" target="_blank" class="btn btn-info">
                                                <i class="mdi mdi-file-pdf"></i> Просмотреть PDF документ
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-primary">Редактировать товар</a>
                                        <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Назад к товарам</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection