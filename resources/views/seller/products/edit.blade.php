@extends('seller.layouts.header-sidebar')

@section('title', 'Редактировать товар')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    Редактировать товар
                </div>

                <div class="mt-6 text-gray-500">
                    Измените информацию о вашем товаре.
                </div>
            </div>

            @if($product->status === 'rejected')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong>Товар был отклонен!</strong>
                    <p>Причина: {{ $product->rejection_reason }}</p>
                </div>
            @endif

            <div class="bg-gray-200 bg-opacity-25 p-6">
                <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Название товара -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Название товара</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Категория -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
                            <select name="category_id" id="category_id" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Тип цены -->
                        <div>
                            <label for="price_type" class="block text-sm font-medium text-gray-700">Тип цены</label>
                            <select name="price_type" id="price_type" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="fixed" {{ old('price_type', $product->price_type) == 'fixed' ? 'selected' : '' }}>Фиксированная цена</option>
                                <option value="hourly" {{ old('price_type', $product->price_type) == 'hourly' ? 'selected' : '' }}>Почасовая оплата</option>
                            </select>
                            @error('price_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Цена -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Цена (руб.)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="0.01"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Изображения -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Изображения товара</label>
                            <p class="text-sm text-gray-500 mb-2">Вы можете загрузить до {{ $maxImages }} изображений</p>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Загрузить файлы</span>
                                            <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                        </label>
                                        <p class="pl-1">или перетащите сюда</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF до 2MB
                                    </p>
                                </div>
                            </div>
                            @if($product->images->count() > 0)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-2">Текущие изображения:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->images as $image)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $product->name }}" class="h-20 w-20 object-cover rounded">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Описание -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Краткое описание</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Детали -->
                        <div class="col-span-2">
                            <label for="details" class="block text-sm font-medium text-gray-700">Подробное описание</label>
                            <textarea name="details" id="details" rows="5"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('details', $product->details) }}</textarea>
                            @error('details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Обновить товар
                        </button>
                        <a href="{{ route('seller.products.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection