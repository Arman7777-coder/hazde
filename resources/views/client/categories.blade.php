@extends('client.layout.app')

@section('title', 'Categories')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endsection

@section('content')
<div class="page-name-link">
    <a href="{{ route('client.home') }}" class="link-page">Главная</a>
    /
    <a href="{{ route('categories.index') }}" class="link-page">Категория</a>
    /
    <a href="#" class="link-page">Авто</a>
</div>

<section class="categories-block">
    <div class="title-block">
        <h1 class="title-block"><span class="font-letter">Ч</span>то ты ищешь?</h1>
    </div>

    <div class="search-bar">
        <input type="text" class="search-input" placeholder="Поиск по категории или имени поставщика">
        <input type="text" class="location-input" placeholder="Местоположение">
        <button class="search-button">Поиск
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.19541 3.52866C8.32043 3.40368 8.48997 3.33347 8.66675 3.33347C8.84352 3.33347 9.01306 3.40368 9.13808 3.52866L13.1381 7.52866C13.2631 7.65368 13.3333 7.82321 13.3333 7.99999C13.3333 8.17677 13.2631 8.3463 13.1381 8.47132L9.13808 12.4713C9.01235 12.5928 8.84395 12.66 8.66915 12.6584C8.49435 12.6569 8.32714 12.5868 8.20354 12.4632C8.07993 12.3396 8.00982 12.1724 8.0083 11.9976C8.00678 11.8228 8.07398 11.6544 8.19541 11.5287L11.0574 8.66666H3.33341C3.1566 8.66666 2.98703 8.59642 2.86201 8.47139C2.73699 8.34637 2.66675 8.1768 2.66675 7.99999C2.66675 7.82318 2.73699 7.65361 2.86201 7.52859C2.98703 7.40356 3.1566 7.33332 3.33341 7.33332H11.0574L8.19541 4.47132C8.07043 4.3463 8.00022 4.17677 8.00022 3.99999C8.00022 3.82321 8.07043 3.65368 8.19541 3.52866Z" fill="white" />
            </svg>
        </button>
    </div>

    <div class="categories-clickable">
        @foreach($categories as $category)
        <a href="{{ route('categories.show', ['id' => $category->id]) }}" class="category-card">
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="image-cat">
            @else
                <img src="{{ asset('images/placeholder.png') }}" alt="{{ $category->name }}" class="image-cat">
            @endif
            <p class="title-cat">{{ $category->name }}</p>
        </a>
        @endforeach
    </div>
</section>

<section class="car-categories">
    <div class="category-card-title">
        <h2 class="title-car-cat">
            <!-- 显示分类描述 -->
            @if(isset($selectedCategory) && $selectedCategory->description)
                @php
                    $description = $selectedCategory->description;
                    $firstLetter = mb_substr($description, 0, 1);
                    $restOfDescription = mb_substr($description, 1);
                @endphp
                <p class="category-description"><span>{{ $firstLetter }}</span>{{ $restOfDescription }}</p>
            @endif
        </h2>
    </div>

    <!-- 过滤器 систем -->
    <div class="filter-bar">
        @if(isset($categoryFilters) && count($categoryFilters) > 0)
            @foreach($categoryFilters as $filter)
                <select class="filter-select" name="{{ $filter->name }}">
                    <option>{{ $filter->title }}</option>
                    <!-- 这里将显示过滤器的选项 -->
                    @if(isset($filter->options) && count($filter->options) > 0)
                        @foreach($filter->options as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    @endif
                </select>
            @endforeach
        @else
{{--            <!-- 默认过滤器 -->--}}
{{--            <select class="filter-select">--}}
{{--                <option>Цена</option>--}}
{{--            </select>--}}
{{--            <select class="filter-select">--}}
{{--                <option>Тип автомобиля</option>--}}
{{--            </select>--}}
{{--            <select class="filter-select">--}}
{{--                <option>Марка / Бренд</option>--}}
{{--            </select>--}}
{{--            <select class="filter-select">--}}
{{--                <option>Вместимость</option>--}}
{{--            </select>--}}
{{--            <select class="filter-select">--}}
{{--                <option>Цвет кузова</option>--}}
{{--            </select>--}}
{{--            <select class="filter-select">--}}
{{--                <option>Цвет салона</option>--}}
{{--            </select>--}}
        @endif
    </div>

    <div class="filter-result-container">
        <div class="car-container">
            <div class="image-container">
                <img src="{{ asset('images/car.png') }}" class="image-car" alt="">
                <span class="favourite-button">
                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.4875 8.07028L7.13438 13.3422C7.36875 13.5609 7.67812 13.6828 8 13.6828C8.32187 13.6828 8.63125 13.5609 8.86563 13.3422L14.5125 8.07028C15.4625 7.18591 16 5.94528 16 4.64841V4.46716C16 2.28278 14.4219 0.420285 12.2688 0.0609095C10.8438 -0.17659 9.39375 0.289035 8.375 1.30778L8 1.68278L7.625 1.30778C6.60625 0.289035 5.15625 -0.17659 3.73125 0.0609095C1.57812 0.420285 0 2.28278 0 4.46716V4.64841C0 5.94528 0.5375 7.18591 1.4875 8.07028Z" fill="#923A3A" />
                    </svg>
                </span>
            </div>
            <h3 class="car-name">Лимузин Хаммер до 20 чел.</h3>
            <p class="company-car">
                <span class="company">ЛимоФаворит</span>
                <span class="price">Цена: 1 800 руб. / час</span>
            </p>
        </div>
    </div>
</section>
@endsection
