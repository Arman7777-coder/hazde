@extends('seller.layouts.header-sidebar')

@section('title', $product->name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl flex justify-between">
                    <div>{{ $product->name }}</div>
                    <div>
                        @if($product->status === 'pending' || $product->status === 'rejected')
                            <a href="{{ route('seller.products.edit', $product) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Редактировать
                            </a>
                        @endif
                        <a href="{{ route('seller.products.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Назад
                        </a>
                    </div>
                </div>
            </div>

            @if($product->status === 'rejected')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong>Товар был отклонен!</strong>
                    <p>Причина: {{ $product->rejection_reason }}</p>
                </div>
            @endif

            <div class="bg-gray-200 bg-opacity-25 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Изображения товара -->
                    <div>
                        @if($product->images->count() > 0)
                            <div class="bg-white rounded-lg shadow-md p-4">
                                @php
                                    $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                                @endphp
                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $primaryImage->alt_text ?? $product->name }}" class="w-full h-64 object-contain rounded">
                                
                                @if($product->images->count() > 1)
                                    <div class="flex flex-wrap gap-2 mt-4">
                                        @foreach($product->images as $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $product->name }}" class="h-16 w-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-blue-500">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-white rounded-lg shadow-md p-4 flex items-center justify-center h-64">
                                <span class="text-gray-500">Нет изображений</span>
                            </div>
                        @endif
                    </div>

                    <!-- Информация о товаре -->
                    <div>
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <h3 class="text-lg font-semibold mb-2">Информация о товаре</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium">Категория:</span>
                                    <span class="ml-2">{{ $product->category->name ?? 'Не указана' }}</span>
                                </div>
                                
                                <div>
                                    <span class="font-medium">Цена:</span>
                                    <span class="ml-2">
                                        @if($product->price)
                                            {{ number_format($product->price, 0, ',', ' ') }} руб.
                                            @if($product->price_type === 'hourly')
                                                / час
                                            @endif
                                        @else
                                            Не указана
                                        @endif
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="font-medium">Статус:</span>
                                    <span class="ml-2">
                                        @if($product->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Ожидает модерации
                                            </span>
                                        @elseif($product->status === 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Одобрен
                                            </span>
                                        @elseif($product->status === 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Отклонен
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                
                                @if($product->is_active)
                                    <div>
                                        <span class="font-medium">Активен:</span>
                                        <span class="ml-2 text-green-600">Да</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Краткое описание -->
                        @if($product->description)
                            <div class="bg-white rounded-lg shadow-md p-4 mt-4">
                                <h3 class="text-lg font-semibold mb-2">Краткое описание</h3>
                                <p class="text-gray-700">{{ $product->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Подробное описание -->
                    @if($product->details)
                        <div class="col-span-2 bg-white rounded-lg shadow-md p-4">
                            <h3 class="text-lg font-semibold mb-2">Подробное описание</h3>
                            <div class="text-gray-700 prose max-w-none">
                                {{ $product->details }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection