@extends('client.layout.app')

@section('title', $product->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fff;
            margin: 2% auto;
            padding: 20px;
            border: none;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .modal-content h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }
        
        .unavailable-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            text-align: center;
            margin-top: 20px;
        }
        
        .unavailable-calendar-header {
            font-weight: bold;
            padding: 12px 0;
            color: #333;
            font-size: 14px;
            background-color: #f0f0f0;
            border-radius: 4px;
        }
        
        .unavailable-calendar-day {
            padding: 12px 0;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fff;
            cursor: default;
            transition: all 0.2s ease;
            font-size: 14px;
            color: #333;
        }
        
        .unavailable-calendar-day.unavailable {
            background-color: #ffebee;
            color: #c62828;
            border-color: #ffcdd2;
            font-weight: bold;
        }
        
        .unavailable-calendar-day.today {
            background-color: #e3f2fd;
            border-color: #bbdefb;
            font-weight: bold;
        }
        
        .unavailable-calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .unavailable-calendar-nav button {
            background: #f5f5f5;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: bold;
            color: #333;
            transition: background-color 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .unavailable-calendar-nav button:hover {
            background: #e0e0e0;
        }
        
        .unavailable-date-tag {
            display: inline-block;
            background: #ffebee;
            color: #c62828;
            padding: 6px 12px;
            margin: 5px;
            border-radius: 20px;
            font-size: 13px;
            border: 1px solid #ffcdd2;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .unavailable-dates-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .unavailable-dates-section h4 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        #unavailable-dates-list {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        #unavailable-dates-list h6 {
            color: #555;
            margin-bottom: 10px;
            margin-top: 0;
        }
        
        /* Rounded avatar style */
        .company-logo {
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Button styles */
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="page-name-link">
        <a href="{{ route('client.home') }}" class="link-page">Главная</a>
        /
        <a href="{{ route('categories.index') }}" class="link-page">Категория</a>
        /
        @if($product->category)
            <a href="{{ route('categories.show', $product->category) }}" class="link-page">{{ $product->category->name }}</a>
            /
        @endif
        <a href="#" class="link-page">{{ $product->name }}</a>
    </div>

    <section class="product-info-container">
        <div class="images-products">
            <div class="images-three">
                @if($product->images->count() > 0)
                    @foreach($product->images as $index => $image)
                        <div class="image-cont {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" data-index="{{ $index + 1 }}" class="image-block">
                        </div>
                    @endforeach
                @else
                    <div class="image-cont active">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="1" class="image-block">
                    </div>
                    <div class="image-cont">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="2" class="image-block">
                    </div>
                    <div class="image-cont">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="3" class="image-block">
                    </div>
                @endif
            </div>
            <div class="image-big">
                @if($product->images->count() > 0)
                    @foreach($product->images as $index => $image)
                        <div class="image-cont-desktop {{ $index == 0 ? 'display' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" data-index="{{ $index + 1 }}" class="image-block">
                        </div>
                    @endforeach
                @else
                    <div class="image-cont-desktop display">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="1" class="image-block">
                    </div>
                    <div class="image-cont-desktop">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="2" class="image-block">
                    </div>
                    <div class="image-cont-desktop">
                        <img src="{{ asset('images/car.png') }}" alt="{{ $product->name }}" data-index="3" class="image-block">
                    </div>
                @endif
            </div>

        </div>
        <div class="info-product">
            <div class="slider-progress"></div>

            <div class="product-title-card">
                <h2 class="product-title">{{ $product->name }}</h2>
                <span class="subtitle-product">{{ $product->user->name ?? 'Продавец' }}</span>
                @if($product->price)
                    <span class="price-product">
                        Цена: {{ number_format($product->price, 0, ' ', ' ') }} руб.
                        @if($product->price_type === 'hourly')
                            / час
                        @else
                            / шт.
                        @endif
                    </span>
                @else
                    <span class="price-product">Цена: По запросу</span>
                @endif
            </div>
            <div class="button-date-product">
                <div class="available-button" id="availableDatesButton">
                    <span class="available-text">Наличие в мои даты</span>
                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.491 13.1162C10.4047 13.1167 10.3192 13.1002 10.2393 13.0676C10.1594 13.0349 10.0868 12.9869 10.0255 12.9261C9.96404 12.8651 9.91526 12.7926 9.88197 12.7127C9.84868 12.6328 9.83154 12.5471 9.83154 12.4606C9.83154 12.374 9.84868 12.2883 9.88197 12.2084C9.91526 12.1285 9.96404 12.056 10.0255 11.995L15.4676 6.55946L10.0255 1.12389C9.90203 1.00043 9.83266 0.832969 9.83266 0.658361C9.83266 0.483752 9.90203 0.316296 10.0255 0.192829C10.149 0.0693628 10.3164 0 10.491 0C10.6656 0 10.8331 0.0693628 10.9566 0.192829L16.8577 6.09393C16.9191 6.15488 16.9679 6.2274 17.0012 6.3073C17.0345 6.3872 17.0516 6.4729 17.0516 6.55946C17.0516 6.64602 17.0345 6.73172 17.0012 6.81162C16.9679 6.89152 16.9191 6.96404 16.8577 7.02499L10.9566 12.9261C10.8953 12.9869 10.8226 13.0349 10.7427 13.0676C10.6629 13.1002 10.5773 13.1167 10.491 13.1162Z"
                            fill="#4A4942" />
                        <path
                            d="M16.3919 7.21516H0.655678C0.481781 7.21516 0.315007 7.14608 0.192044 7.02312C0.0690801 6.90016 0 6.73338 0 6.55949C0 6.38559 0.0690801 6.21882 0.192044 6.09585C0.315007 5.97289 0.481781 5.90381 0.655678 5.90381H16.3919C16.5658 5.90381 16.7326 5.97289 16.8556 6.09585C16.9785 6.21882 17.0476 6.38559 17.0476 6.55949C17.0476 6.73338 16.9785 6.90016 16.8556 7.02312C16.7326 7.14608 16.5658 7.21516 16.3919 7.21516Z"
                            fill="#4A4942" />
                    </svg>
                </div>
                <div class="izbrannoe-button" id="likeButton" data-product-id="{{ $product->id }}">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.72852 2.97852C9.57657 2.13051 10.7615 1.71377 11.9492 1.83887L12.1865 1.87109C14.0985 2.19023 15.4998 3.84436 15.5 5.78418V5.96582C15.5 7.12442 15.0197 8.23213 14.1719 9.02148L14.1709 9.02246L8.52441 14.2939C8.38287 14.4261 8.19557 14.5 8 14.5C7.80443 14.5 7.61713 14.4261 7.47559 14.2939L1.8291 9.02246L1.82812 9.02148C0.980272 8.23213 0.500008 7.12442 0.5 5.96582V5.78418C0.5 3.90501 1.81531 2.29428 3.63574 1.90527L3.81348 1.87109C5.07913 1.66018 6.36694 2.07402 7.27148 2.97852L8 3.70703L8.72852 2.97852Z"
                            stroke="#923A3A" fill="{{ $product->likes()->where('ip_address', request()->ip())->exists() ? '#923A3A' : 'none' }}"/>
                    </svg>
                    <span class="izbrannoe-text">В избранное</span>
                </div>
            </div>
            <div class="car-info">
                <p class="info-car-paragraph-short">
                    @php
                        // Get first 4 filter values for display in short info
                        $firstFourFilters = $product->filterValues->take(4);
                    @endphp

                    @foreach($firstFourFilters as $filterValue)
                        {{ $filterValue->filter->title ?? $filterValue->filter->name }}: 
                        <span class="{{ str_replace(' ', '-', strtolower($filterValue->filter->name)) }}">
                            {{ $filterValue->filterOption->name ?? $filterValue->value }}
                        </span> <br>
                    @endforeach
                </p>

                @if($product->details)
                <p class="options-car">
                    {{ $product->details }}
                </p>
                @endif

                <p class="car-type">
                    @php
                        // Get remaining filter values for display in car type section
                        $remainingFilters = $product->filterValues->skip(4);
                    @endphp
                    
                    @foreach($remainingFilters as $filterValue)
                        <span class="car-opt">
                            {{ $filterValue->filter->title ?? $filterValue->filter->name }}
                            <span class="spec-dots"></span>
                            <span class="{{ str_replace(' ', '-', strtolower($filterValue->filter->name)) }}">
                                {{ $filterValue->filterOption->name ?? $filterValue->value }}
                            </span>
                        </span>
                    @endforeach
                </p>

                <div class="link-buy-company-button">
                    <div class="company-link">
                        @if($product->user && $product->user->avatar)
                            <img src="{{ asset($product->user->avatar) }}" class="company-logo" alt="{{ $product->user->name }}">
                        @else
                            <img src="{{ asset('images/logo-com.png') }}" class="company-logo" alt="Логотип компании">
                        @endif
                        <p class="paragraph-company-name-stars">
                            <span class="comp-name">{{ $product->user->name ?? 'Продавец' }}</span>
                            <span class="comp-stars">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.64574 13.9983L5.5513 14.0494C5.07058 14.3138 4.75513 14.0748 4.84674 13.5157L5.40869 10.1053L3.03341 7.68852C2.6443 7.29279 2.76424 6.90557 3.30541 6.82435L5.64858 6.46924V13.9993L5.64574 13.9983Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4393L5.646 13.9996V6.46856L6.58572 6.32784L8.05339 3.2225C8.08328 3.12507 8.13995 3.038 8.21693 2.97121C8.29391 2.90441 8.3881 2.86059 8.48877 2.84473V12.4393Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4418L11.3334 13.9982V6.48044L10.389 6.33783L8.9251 3.23911C8.8953 3.14162 8.83867 3.05449 8.76167 2.98768C8.68467 2.92087 8.59043 2.87709 8.48971 2.86133V12.4418H8.48877Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.3335 13.9982L11.4279 14.0492C11.9087 14.3127 12.2241 14.0747 12.1325 13.5156L11.5715 10.11L13.9468 7.69786C14.3359 7.30308 14.2159 6.9168 13.6776 6.83464L11.3335 6.48047V13.9982Z"
                                        fill="#E9F1F2" />
                                </svg>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.64574 13.9983L5.5513 14.0494C5.07058 14.3138 4.75513 14.0748 4.84674 13.5157L5.40869 10.1053L3.03341 7.68852C2.6443 7.29279 2.76424 6.90557 3.30541 6.82435L5.64858 6.46924V13.9993L5.64574 13.9983Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4393L5.646 13.9996V6.46856L6.58572 6.32784L8.05339 3.2225C8.08328 3.12507 8.13995 3.038 8.21693 2.97121C8.29391 2.90441 8.3881 2.86059 8.48877 2.84473V12.4393Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4418L11.3334 13.9982V6.48044L10.389 6.33783L8.9251 3.23911C8.8953 3.14162 8.83867 3.05449 8.76167 2.98768C8.68467 2.92087 8.59043 2.87709 8.48971 2.86133V12.4418H8.48877Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.3335 13.9982L11.4279 14.0492C11.9087 14.3127 12.2241 14.0747 12.1325 13.5156L11.5715 10.11L13.9468 7.69786C14.3359 7.30308 14.2159 6.9168 13.6776 6.83464L11.3335 6.48047V13.9982Z"
                                        fill="#E9F1F2" />
                                </svg>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.64574 13.9983L5.5513 14.0494C5.07058 14.3138 4.75513 14.0748 4.84674 13.5157L5.40869 10.1053L3.03341 7.68852C2.6443 7.29279 2.76424 6.90557 3.30541 6.82435L5.64858 6.46924V13.9993L5.64574 13.9983Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4393L5.646 13.9996V6.46856L6.58572 6.32784L8.05339 3.2225C8.08328 3.12507 8.13995 3.038 8.21693 2.97121C8.29391 2.90441 8.3881 2.86059 8.48877 2.84473V12.4393Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4418L11.3334 13.9982V6.48044L10.389 6.33783L8.9251 3.23911C8.8953 3.14162 8.83867 3.05449 8.76167 2.98768C8.68467 2.92087 8.59043 2.87709 8.48971 2.86133V12.4418H8.48877Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.3335 13.9982L11.4279 14.0492C11.9087 14.3127 12.2241 14.0747 12.1325 13.5156L11.5715 10.11L13.9468 7.69786C14.3359 7.30308 14.2159 6.9168 13.6776 6.83464L11.3335 6.48047V13.9982Z"
                                        fill="#E9F1F2" />
                                </svg>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.64574 13.9983L5.5513 14.0494C5.07058 14.3138 4.75513 14.0748 4.84674 13.5157L5.40869 10.1053L3.03341 7.68852C2.6443 7.29279 2.76424 6.90557 3.30541 6.82435L5.64858 6.46924V13.9993L5.64574 13.9983Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4393L5.646 13.9996V6.46856L6.58572 6.32784L8.05339 3.2225C8.08328 3.12507 8.13995 3.038 8.21693 2.97121C8.29391 2.90441 8.3881 2.86059 8.48877 2.84473V12.4393Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.48877 12.4418L11.3334 13.9982V6.48044L10.389 6.33783L8.9251 3.23911C8.8953 3.14162 8.83867 3.05449 8.76167 2.98768C8.68467 2.92087 8.59043 2.87709 8.48971 2.86133V12.4418H8.48877Z"
                                        fill="#E9F1F2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.3335 13.9982L11.4279 14.0492C11.9087 14.3127 12.2241 14.0747 12.1325 13.5156L11.5715 10.11L13.9468 7.69786C14.3359 7.30308 14.2159 6.9168 13.6776 6.83464L11.3335 6.48047V13.9982Z"
                                        fill="#E9F1F2" />
                                </svg>
                                <span class="ocenka">0.0</span>
                            </span>
                        </p>
                    </div>
                    <div class="go-to-link">
                        <span>Перейти</span>
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.491 13.1162C10.4047 13.1167 10.3192 13.1002 10.2393 13.0676C10.1594 13.0349 10.0868 12.9869 10.0255 12.9261C9.96404 12.8651 9.91526 12.7926 9.88197 12.7127C9.84868 12.6328 9.83154 12.5471 9.83154 12.4606C9.83154 12.374 9.84868 12.2883 9.88197 12.2084C9.91526 12.1285 9.96404 12.056 10.0255 11.995L15.4676 6.55946L10.0255 1.12389C9.90203 1.00043 9.83266 0.832969 9.83266 0.658361C9.83266 0.483752 9.90203 0.316296 10.0255 0.192829C10.149 0.0693628 10.3164 0 10.491 0C10.6656 0 10.8331 0.0693628 10.9566 0.192829L16.8577 6.09393C16.9191 6.15488 16.9679 6.2274 17.0012 6.3073C17.0345 6.3872 17.0516 6.4729 17.0516 6.55946C17.0516 6.64602 17.0345 6.73172 17.0012 6.81162C16.9679 6.89152 16.9191 6.96404 16.8577 7.02499L10.9566 12.9261C10.8953 12.9869 10.8226 13.0349 10.7427 13.0676C10.6629 13.1002 10.5773 13.1167 10.491 13.1162Z"
                                fill="#4A4942" />
                            <path
                                d="M16.3919 7.21516H0.655678C0.481781 7.21516 0.315007 7.14608 0.192044 7.02312C0.0690801 6.90016 0 6.73338 0 6.55949C0 6.38559 0.0690801 6.21882 0.192044 6.09585C0.315007 5.97289 0.481781 5.90381 0.655678 5.90381H16.3919C16.5658 5.90381 16.7326 5.97289 16.8556 6.09585C16.9785 6.21882 17.0476 6.38559 17.0476 6.55949C17.0476 6.73338 16.9785 6.90016 16.8556 7.02312C16.7326 7.14608 16.5658 7.21516 16.3919 7.21516Z"
                                fill="#4A4942" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Similar Products Section -->
    <section class="car-categories">
        <div class="category-card-title">
            <h2 class="title-car-cat">Похожие</h2>
        </div>
        <div class="filter-result-container">
            @if(isset($similarProducts) && $similarProducts->count() > 0)
                @foreach($similarProducts as $similarProduct)
                <div class="car-container">
                    <div class="image-container">
                        @if($similarProduct->images->count() > 0)
                            <img src="{{ asset('storage/' . $similarProduct->images->first()->image_path) }}" class="image-car" alt="{{ $similarProduct->name }}">
                        @else
                            <img src="{{ asset('images/car.png') }}" class="image-car" alt="{{ $similarProduct->name }}">
                        @endif
                        <span class="favourite-button">
                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.4875 8.07028L7.13438 13.3422C7.36875 13.5609 7.67812 13.6828 8 13.6828C8.32187 13.6828 8.63125 13.5609 8.86563 13.3422L14.5125 8.07028C15.4625 7.18591 16 5.94528 16 4.64841V4.46716C16 2.28278 14.4219 0.420285 12.2688 0.0609095C10.8438 -0.17659 9.39375 0.289035 8.375 1.30778L8 1.68278L7.625 1.30778C6.60625 0.289035 5.15625 -0.17659 3.73125 0.0609095C1.57812 0.420285 0 2.28278 0 4.46716V4.64841C0 5.94528 0.5375 7.18591 1.4875 8.07028Z" fill="#923A3A" />
                            </svg>
                        </span>
                    </div>
                    <h3 class="car-name">{{ $similarProduct->name }}</h3>
                    <p class="company-car">
                        <span class="company">{{ $similarProduct->user->name ?? 'Продавец' }}</span>
                        <span class="price">
                            @if($similarProduct->price)
                                Цена: {{ number_format($similarProduct->price, 0, ' ', ' ') }} руб.
                                @if($similarProduct->price_type === 'hourly')
                                    / час
                                @else
                                    / шт.
                                @endif
                            @else
                                Цена: По запросу
                            @endif
                        </span>
                    </p>
                </div>
                @endforeach
            @else
                <div class="no-similar-products">
                    <p>Похожих товаров не найдено.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Calendar showing unavailable dates -->
    <div class="unavailable-dates-section">
        <h4>Недоступные даты</h4>
        <div id="unavailable-dates-preview" class="mt-3"></div>
        <button id="viewAllDatesButton" class="btn btn-outline-primary mt-3">Посмотреть все даты</button>
    </div>

    <!-- Unavailable Dates Modal -->
    <div id="unavailableDatesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Недоступные даты</h2>
            <div id="unavailable-dates-calendar" class="mt-3"></div>
            <div id="unavailable-dates-list" class="mt-3"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const smallImages = document.querySelectorAll('.images-three .image-block');
            const bigContainers = document.querySelectorAll('.image-big .image-cont-desktop');
            const imageContainers = document.querySelectorAll('.images-three .image-cont');

            function updateDisplayForWidth() {
                if (window.innerWidth < 768) {
                    // On mobile — show all big images
                    bigContainers.forEach(cont => cont.classList.add('display'));
                } else {
                    // On desktop — only one visible at a time
                    bigContainers.forEach(cont => cont.classList.remove('display'));
                    const first = bigContainers[0];
                    if (first) first.classList.add('display'); // show first by default
                }
            }

            // Run once on load
            updateDisplayForWidth();

            // Run again on resize
            window.addEventListener('resize', updateDisplayForWidth);

            // Click handling (only for desktop)
            smallImages.forEach(img => {
                img.addEventListener('click', () => {
                    if (window.innerWidth < 768) return; // skip for mobile

                    const index = img.dataset.index;

                    // Update active state for small images
                    imageContainers.forEach(cont => cont.classList.remove('active'));
                    img.parentElement.classList.add('active');

                    // Update big image display
                    bigContainers.forEach(cont => cont.classList.remove('display'));
                    const target = document.querySelector(`.image-big .image-cont-desktop img[data-index="${index}"]`);
                    if (target) target.parentElement.classList.add('display');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Modal functionality
            const modal = document.getElementById("unavailableDatesModal");
            const btn = document.getElementById("availableDatesButton");
            const span = document.getElementsByClassName("close")[0];
            const viewAllDatesButton = document.getElementById("viewAllDatesButton");

            // When the user clicks the button, open the modal
            if (btn) {
                btn.addEventListener('click', function() {
                    modal.style.display = "block";
                    loadUnavailableDates();
                });
            }

            // When the user clicks the "View all dates" button, open the modal
            if (viewAllDatesButton) {
                viewAllDatesButton.addEventListener('click', function() {
                    modal.style.display = "block";
                    loadUnavailableDates();
                });
            }

            // When the user clicks on <span> (x), close the modal
            if (span) {
                span.addEventListener('click', function() {
                    modal.style.display = "none";
                });
            }

            // When the user clicks anywhere outside of the modal, close it
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });

            // Like button functionality
            const likeButton = document.getElementById('likeButton');
            if (likeButton) {
                likeButton.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const heartPath = this.querySelector('svg path');
                    
                    fetch(`/products/${productId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update heart icon fill based on like status
                        if (data.liked) {
                            heartPath.setAttribute('fill', '#923A3A');
                        } else {
                            heartPath.setAttribute('fill', 'none');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            }

            // Load unavailable dates for preview
            loadUnavailableDatesPreview();

            function loadUnavailableDatesPreview() {
                fetch(`/products/{{ $product->id }}/unavailable-dates`)
                    .then(response => response.json())
                    .then(dates => {
                        renderUnavailableDatesPreview(dates);
                    });
            }

            function loadUnavailableDates() {
                fetch(`/products/{{ $product->id }}/unavailable-dates`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(dates => {
                        renderUnavailableDatesCalendar(dates);
                        renderUnavailableDatesList(dates);
                    })
                    .catch(error => {
                        console.error('Error loading unavailable dates:', error);
                        const calendarEl = document.getElementById('unavailable-dates-calendar');
                        const listEl = document.getElementById('unavailable-dates-list');
                        if (calendarEl) calendarEl.innerHTML = '<p>Error loading dates. Please try again later.</p>';
                        if (listEl) listEl.innerHTML = '<p>Error loading dates. Please try again later.</p>';
                    });
            }

            function renderUnavailableDatesPreview(unavailableDates) {
                const previewEl = document.getElementById('unavailable-dates-preview');
                previewEl.innerHTML = '';

                if (unavailableDates.length === 0) {
                    previewEl.innerHTML = '<p style="color: #666; font-style: italic;">Нет недоступных дат</p>';
                    return;
                }

                // Show only first 5 dates
                const datesToShow = unavailableDates.slice(0, 5);
                const list = document.createElement('div');
                list.style.display = 'flex';
                list.style.flexWrap = 'wrap';
                list.style.gap = '5px';

                datesToShow.forEach(date => {
                    const dateTag = document.createElement('span');
                    dateTag.className = 'unavailable-date-tag';
                    dateTag.textContent = formatDate(date);
                    list.appendChild(dateTag);
                });

                // If there are more dates, show a message
                if (unavailableDates.length > 5) {
                    const moreTag = document.createElement('span');
                    moreTag.style.color = '#666';
                    moreTag.style.fontSize = '13px';
                    moreTag.style.marginLeft = '10px';
                    moreTag.textContent = `и ещё ${unavailableDates.length - 5} дат...`;
                    list.appendChild(moreTag);
                }

                previewEl.appendChild(list);
            }

            function renderUnavailableDatesCalendar(unavailableDates) {
                let currentMonth = new Date().getMonth();
                let currentYear = new Date().getFullYear();

                renderUnavailableCalendar(currentMonth, currentYear, unavailableDates);
            }

            function renderUnavailableCalendar(month, year, unavailableDates) {
                const calendarEl = document.getElementById('unavailable-dates-calendar');
                calendarEl.innerHTML = '';

                // Calendar navigation
                const nav = document.createElement('div');
                nav.className = 'unavailable-calendar-nav';

                const prevButton = document.createElement('button');
                prevButton.innerHTML = '&larr;';
                prevButton.title = 'Предыдущий месяц';
                prevButton.addEventListener('click', () => {
                    month--;
                    if (month < 0) {
                        month = 11;
                        year--;
                    }
                    renderUnavailableCalendar(month, year, unavailableDates);
                });

                const monthYear = document.createElement('span');
                monthYear.textContent = new Date(year, month).toLocaleString('ru-RU', { month: 'long', year: 'numeric' });
                monthYear.style.textTransform = 'capitalize';
                monthYear.style.fontWeight = 'bold';
                monthYear.style.fontSize = '18px';
                monthYear.style.color = '#333';

                const nextButton = document.createElement('button');
                nextButton.innerHTML = '&rarr;';
                nextButton.title = 'Следующий месяц';
                nextButton.addEventListener('click', () => {
                    month++;
                    if (month > 11) {
                        month = 0;
                        year++;
                    }
                    renderUnavailableCalendar(month, year, unavailableDates);
                });

                nav.appendChild(prevButton);
                nav.appendChild(monthYear);
                nav.appendChild(nextButton);
                calendarEl.appendChild(nav);

                // Calendar header
                const days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
                const header = document.createElement('div');
                header.className = 'unavailable-calendar';

                days.forEach(day => {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'unavailable-calendar-header';
                    dayEl.textContent = day;
                    header.appendChild(dayEl);
                });

                calendarEl.appendChild(header);

                // Calendar days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                const calendar = document.createElement('div');
                calendar.className = 'unavailable-calendar';

                // Empty cells for days before the first day of the month
                for (let i = 1; i < (firstDay || 7); i++) {
                    const emptyCell = document.createElement('div');
                    calendar.appendChild(emptyCell);
                }

                // Days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'unavailable-calendar-day';
                    dayEl.textContent = day;

                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Highlight today
                    const today = new Date();
                    if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
                        dayEl.classList.add('today');
                    }

                    // Mark unavailable dates
                    if (unavailableDates.includes(dateStr)) {
                        dayEl.classList.add('unavailable');
                    }

                    calendar.appendChild(dayEl);
                }

                calendarEl.appendChild(calendar);
            }

            function renderUnavailableDatesList(unavailableDates) {
                const listEl = document.getElementById('unavailable-dates-list');
                listEl.innerHTML = '';

                if (unavailableDates.length === 0) {
                    listEl.innerHTML = '<p style="color: #666; font-style: italic;">Нет недоступных дат</p>';
                    return;
                }

                const title = document.createElement('h6');
                title.textContent = 'Список недоступных дат:';
                title.style.color = '#333';
                title.style.marginBottom = '15px';
                listEl.appendChild(title);

                const list = document.createElement('div');
                list.style.display = 'flex';
                list.style.flexWrap = 'wrap';
                list.style.gap = '5px';

                unavailableDates.forEach(date => {
                    const dateTag = document.createElement('span');
                    dateTag.className = 'unavailable-date-tag';
                    dateTag.textContent = formatDate(date);
                    list.appendChild(dateTag);
                });

                listEl.appendChild(list);
            }

            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('ru-RU');
            }
        });
    </script>
@endsection