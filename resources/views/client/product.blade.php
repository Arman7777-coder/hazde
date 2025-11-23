@extends('client.layout.app')

@section('title', $product->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-src/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
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
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            font-family: URW Bookman, serif;
        }
        
        .modal-content h2 {
            margin-top: 0;
            color: #923A3A;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            font-family: URW Bookman, serif;
            font-style: italic;
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
        
        /* PDF Button Styles */
        .pdf-document-section {
            display: flex;
            justify-content: flex-start;
            margin-top: 15px;
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            background-color: #923A3A;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            font-family: URW Bookman, serif;
            font-style: italic;
        }
        
        .btn-primary:hover {
            background-color: #7a2f2f;
        }
        
        .btn-primary svg {
            fill: white;
        }
        
        /* Seller Modal Styles */
        .seller-info {
            margin-top: 20px;
        }
        
        .seller-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .seller-header .company-logo {
            width: 60px;
            height: 60px;
        }
        
        .seller-header h3 {
            color: #923A3A;
            margin: 0 0 5px 0;
            font-family: URW Bookman, serif;
            font-style: italic;
        }
        
        .verified-badge {
            background-color: #3B82F6;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
            margin-top: 5px;
            font-family: URW Bookman, serif;
        }
        
        .seller-details h4 {
            margin-top: 0;
            color: #923A3A;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-family: URW Bookman, serif;
            font-style: italic;
        }
        
        .contact-info p {
            margin: 8px 0;
            color: #4A4942;
            font-family: URW Bookman, serif;
        }
        
        .contact-info strong {
            color: #923A3A;
        }
        
        .rating-display {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        
        .rating-stars {
            display: flex;
            gap: 2px;
        }
        
        .rating-stars svg {
            fill: #FFD700;
            width: 20px;
            height: 20px;
        }
        
        .rating-value {
            font-weight: bold;
            font-size: 18px;
            color: #923A3A;
        }
        
        .rating-form {
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #923A3A;
            font-family: URW Bookman, serif;
        }
        
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: URW Bookman, serif;
        }
        
        /* Star rating styling */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
            padding: 0 2px;
        }
        
        .star-rating label:before {
            content: "★";
        }
        
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating input[type="radio"]:checked + label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #FFD700;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
        
        /* Calendar styles for unavailable dates */
        #unavailable-dates-calendar {
            margin: 20px 0;
            width: 100%;
        }
        
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .calendar-container {
            width: 100%;
        }
        
        #datepicker {
            width: 100%;
        }
        
        .datepicker {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
        }
        
        .datepicker table {
            width: 100%;
        }
        
        .datepicker table tr td,
        .datepicker table tr th {
            width: 14.28%;
            text-align: center;
            padding: 10px 0;
        }
        
        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: #ffdddd !important;
            color: #999 !important;
            position: relative;
        }
        
        .datepicker table tr td.disabled:before {
            content: "✕";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: #d00;
            font-weight: bold;
        }
        
        .datepicker table tr td.today {
            background-color: #923A3A !important;
            color: white !important;
            border-radius: 50%;
        }
        
        .datepicker table tr td.active {
            background-color: #3B82F6 !important;
            color: white !important;
            border-radius: 50%;
        }
        
        .datepicker .datepicker-switch,
        .datepicker .prev,
        .datepicker .next {
            font-size: 18px;
            font-weight: bold;
            color: #923A3A;
        }
        
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker .datepicker-switch:hover {
            background-color: #f5f5f5 !important;
            color: #7a2f2f;
        }
        
        #unavailable-dates-list {
            margin-top: 20px;
        }
        
        #unavailable-dates-list h3 {
            color: #923A3A;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        #unavailable-dates-list ul {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 10px;
            background: #f9f9f9;
        }
        
        #unavailable-dates-list li {
            border-bottom: 1px solid #eee;
            padding: 8px 0;
            color: #4A4942;
        }
        
        #unavailable-dates-list li:last-child {
            border-bottom: none;
        }
        
        .calendar-title {
            text-align: center;
            color: #923A3A;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
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
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="subtitle-product">{{ $product->user->name ?? 'Продавец' }}</span>
                    @if($product->user->is_verified_seller)
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="12" fill="#3B82F6"/>
                            <path d="M17.3333 8L9.99996 15.3333L6.66663 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif
                </div>
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
                            <span class="comp-name">
                                {{ $product->user->name ?? 'Продавец' }}
                                @if($product->user->is_verified_seller)
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle; margin-left: 4px;">
                                        <circle cx="12" cy="12" r="12" fill="#3B82F6"/>
                                        <path d="M17.3333 8L9.99996 15.3333L6.66663 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </span>
                            <span class="comp-stars">
                                @php
                                    $sellerRating = ($product->user && $product->user->seller_rating) ? $product->user->seller_rating : 0;
                                @endphp
                                
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $sellerRating)
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.64574 13.9983L5.5513 14.0494C5.07058 14.3138 4.75513 14.0748 4.84674 13.5157L5.40869 10.1053L3.03341 7.68852C2.6443 7.29279 2.76424 6.90557 3.30541 6.82435L5.64858 6.46924V13.9993L5.64574 13.9983Z"
                                                fill="#FFD700" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.48877 12.4393L5.646 13.9996V6.46856L6.58572 6.32784L8.05339 3.2225C8.08328 3.12507 8.13995 3.038 8.21693 2.97121C8.29391 2.90441 8.3881 2.86059 8.48877 2.84473V12.4393Z"
                                                fill="#FFD700" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.48877 12.4418L11.3334 13.9982V6.48044L10.389 6.33783L8.9251 3.23911C8.8953 3.14162 8.83867 3.05449 8.76167 2.98768C8.68467 2.92087 8.59043 2.87709 8.48971 2.86133V12.4418H8.48877Z"
                                                fill="#FFD700" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.3335 13.9982L11.4279 14.0492C11.9087 14.3127 12.2241 14.0747 12.1325 13.5156L11.5715 10.11L13.9468 7.69786C14.3359 7.30308 14.2159 6.9168 13.6776 6.83464L11.3335 6.48047V13.9982Z"
                                                fill="#FFD700" />
                                        </svg>
                                    @else
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
                                    @endif
                                @endfor
                                <span class="ocenka">{{ number_format($sellerRating, 1) }}</span>
                            </span>
                        </p>
                    </div>
                    <!-- Updated button to trigger modal -->
                    <div class="go-to-link" id="openSellerModal">
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
                
                <!-- PDF Document Button -->
                @if($product->pdf_document_path)
                <div class="pdf-document-section mt-3">
                    <a href="{{ asset('storage/' . $product->pdf_document_path) }}" target="_blank" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                            <path d="M14 5.33333L11.3333 2.66666H4C3.26667 2.66666 2.66667 3.26666 2.66667 4V12C2.66667 12.7333 3.26667 13.3333 4 13.3333H12C12.7333 13.3333 13.3333 12.7333 13.3333 12V6.66666L14 5.33333ZM11.3333 3.99999L12.6667 5.33333H11.3333V3.99999ZM12.6667 12C12.6667 12.3667 12.3667 12.6667 12 12.6667H4C3.63333 12.6667 3.33333 12.3667 3.33333 12V4C3.33333 3.63333 3.63333 3.33333 4 3.33333H10.6667V6C10.6667 6.36666 10.9667 6.66666 11.3333 6.66666H12.6667V12ZM5.33333 7.33333H10.6667V7.99999H5.33333V7.33333ZM5.33333 9.33333H9.33333V9.99999H5.33333V9.33333ZM5.33333 11.3333H8V12H5.33333V11.3333Z" fill="#fff"/>
                        </svg>
                        Открыть PDF документ
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Seller Information Modal -->
    <div id="sellerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Информация о продавце</h2>
            
            <div class="seller-info">
                <div class="seller-header">
                    @if($product->user && $product->user->avatar)
                        <img src="{{ asset($product->user->avatar) }}" class="company-logo" alt="{{ $product->user->name }}">
                    @else
                        <img src="{{ asset('images/logo-com.png') }}" class="company-logo" alt="Логотип компании">
                    @endif
                    <div>
                        <h3>{{ $product->user->name ?? 'Продавец' }}</h3>
                        @if($product->user->is_verified_seller)
                            <span class="verified-badge">Проверенный продавец</span>
                        @endif
                    </div>
                </div>
                
                <div class="seller-details">
                    <div class="contact-info">
                        <h4>Контактная информация</h4>
                        <p><strong>Email:</strong> {{ $product->user->email ?? 'Не указан' }}</p>
                        @if($product->user->phone_number)
                            <p><strong>Телефон:</strong> {{ $product->user->phone_number }}</p>
                        @endif
                        @if($product->user->company_name)
                            <p><strong>Компания:</strong> {{ $product->user->company_name }}</p>
                        @endif
                    </div>
                    
                    <div class="rating-section">
                        <h4>Рейтинг продавца</h4>
                        <div class="rating-display">
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= ($product->user->seller_rating ?? 0))
                                        <svg width="20" height="20" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.5 0L10.9 5.1H16.7L12.1 8.9L13.2 14.5L8.5 11.5L3.8 14.5L4.9 8.9L0.3 5.1H6.1L8.5 0Z" fill="#FFD700"/>
                                        </svg>
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.5 0L10.9 5.1H16.7L12.1 8.9L13.2 14.5L8.5 11.5L3.8 14.5L4.9 8.9L0.3 5.1H6.1L8.5 0Z" fill="#ddd"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-value">{{ number_format(($product->user && $product->user->seller_rating) ? $product->user->seller_rating : 0, 1) }}</span>
                            <span>({{ ($product->user && $product->user->has_seller_rating) ? 1 : 0 }} отзывов)</span>
                        </div>
                    </div>
                    
                    <div class="rating-form">
                        <h4>Оценить продавца</h4>
                        <div id="ratingResponse"></div>
                        <form id="sellerRatingForm">
                            @csrf
                            <div class="form-group">
                                <label for="rating">Ваша оценка:</label>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="5 звезд">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="4 звезды">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="3 звезды">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="2 звезды">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="1 звезда">1 star</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Отправить оценку</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                        <span class="company">
                            {{ $similarProduct->user->name ?? 'Продавец' }}
                            @if($similarProduct->user->is_verified_seller)
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle; margin-left: 4px;">
                                    <circle cx="12" cy="12" r="12" fill="#3B82F6"/>
                                    <path d="M17.3333 8L9.99996 15.3333L6.66663 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            @endif
                        </span>
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
    <div id="unavailableDatesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Недоступные даты</h2>
            <div class="modal-body">
                <div id="unavailable-dates-calendar" class="mt-3"></div>
                <div id="unavailable-dates-list" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin-src/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-src/libs/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js') }}"></script>
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
            
            // Seller modal functionality
            const openSellerModal = document.getElementById('openSellerModal');
            const sellerModal = document.getElementById('sellerModal');
            const closeSellerModal = document.querySelector('#sellerModal .close');
            
            if (openSellerModal && sellerModal) {
                openSellerModal.addEventListener('click', function() {
                    sellerModal.style.display = 'block';
                });
                
                closeSellerModal.addEventListener('click', function() {
                    sellerModal.style.display = 'none';
                });
                
                window.addEventListener('click', function(event) {
                    if (event.target == sellerModal) {
                        sellerModal.style.display = 'none';
                    }
                });
            }
            
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
            
            // Handle seller rating form submission
            const sellerRatingForm = document.getElementById('sellerRatingForm');
            if (sellerRatingForm) {
                sellerRatingForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = new FormData(this);
                    const rating = formData.get('rating');
                    const ratingResponse = document.getElementById('ratingResponse');
                    
                    if (!rating) {
                        ratingResponse.innerHTML = '<div class="alert alert-error">Пожалуйста, выберите оценку</div>';
                        return;
                    }
                    
                    // Submit rating via AJAX
                    fetch(`/sellers/{{$product->user->id}}/ratings`, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            ratingResponse.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                            
                            // Update rating display
                            if (data.data && data.data.average_rating !== undefined) {
                                document.querySelector('.rating-value').textContent = parseFloat(data.data.average_rating).toFixed(1);
                                document.querySelector('.rating-display span:last-child').textContent = `(${data.data.total_ratings} отзывов)`;
                            }
                            
                            // Reset form after short delay
                            setTimeout(() => {
                                sellerRatingForm.reset();
                                ratingResponse.innerHTML = '';
                            }, 3000);
                        } else {
                            ratingResponse.innerHTML = '<div class="alert alert-error">' + data.message + '</div>';
                        }
                    })
                    .catch(error => {
                        ratingResponse.innerHTML = '<div class="alert alert-error">Произошла ошибка при отправке оценки</div>';
                        console.error('Error:', error);
                    });
                });
            }
            
            // Available in my dates modal functionality
            const availableDatesButton = document.getElementById('availableDatesButton');
            const unavailableDatesModal = document.getElementById('unavailableDatesModal');
            const closeUnavailableDatesModal = document.querySelector('#unavailableDatesModal .close');
            
            if (availableDatesButton && unavailableDatesModal) {
                availableDatesButton.addEventListener('click', function() {
                    // Show the modal
                    unavailableDatesModal.style.display = 'block';
                    
                    // Fetch and display unavailable dates
                    fetch(`/products/{{$product->id}}/unavailable-dates`)
                        .then(response => response.json())
                        .then(unavailableDates => {
                            // Create a simple calendar view
                            const calendarContainer = document.getElementById('unavailable-dates-calendar');
                            const listContainer = document.getElementById('unavailable-dates-list');
                            
                            // Clear previous content
                            calendarContainer.innerHTML = '';
                            listContainer.innerHTML = '';
                            
                            if (unavailableDates.length === 0) {
                                calendarContainer.innerHTML = '<p>Нет недоступных дат</p>';
                                return;
                            }
                            
                            // Add title for calendar
                            const calendarTitle = document.createElement('div');
                            calendarTitle.className = 'calendar-title';
                            calendarTitle.textContent = 'Календарь недоступных дат';
                            calendarContainer.appendChild(calendarTitle);
                            
                            // Display calendar
                            const calendarDiv = document.createElement('div');
                            calendarDiv.className = 'calendar-container';
                            calendarDiv.innerHTML = '<div id="datepicker"></div>';
                            calendarContainer.appendChild(calendarDiv);
                            
                            // Initialize datepicker
                            const datepicker = $('#datepicker').datepicker({
                                format: 'yyyy-mm-dd',
                                autoclose: true,
                                todayHighlight: true,
                                language: 'ru',
                                startDate: new Date(),
                                orientation: 'bottom auto',
                                daysOfWeekHighlighted: "0,6", // Highlight weekends
                                weekStart: 1 // Start week on Monday
                            });
                            
                            // Mark unavailable dates
                            datepicker.datepicker('setDatesDisabled', unavailableDates);
                            
                            // Trigger resize to ensure proper display
                            setTimeout(() => {
                                datepicker.datepicker('show');
                                $('.datepicker').css('display', 'block');
                            }, 100);
                            
                            // Display list of unavailable dates
                            const title = document.createElement('h3');
                            title.textContent = 'Недоступные даты:';
                            listContainer.appendChild(title);
                            
                            const dateList = document.createElement('ul');
                            dateList.style.listStyle = 'none';
                            dateList.style.padding = '0';
                            
                            unavailableDates.forEach(date => {
                                const listItem = document.createElement('li');
                                listItem.style.padding = '5px 0';
                                listItem.textContent = formatDate(date);
                                dateList.appendChild(listItem);
                            });
                            
                            listContainer.appendChild(dateList);
                        })
                        .catch(error => {
                            console.error('Error fetching unavailable dates:', error);
                            document.getElementById('unavailable-dates-calendar').innerHTML = '<p>Ошибка загрузки недоступных дат</p>';
                        });
                });
                
                // Close modal when close button is clicked
                closeUnavailableDatesModal.addEventListener('click', function() {
                    unavailableDatesModal.style.display = 'none';
                });
                
                // Close modal when clicking outside of it
                window.addEventListener('click', function(event) {
                    if (event.target == unavailableDatesModal) {
                        unavailableDatesModal.style.display = 'none';
                    }
                });
            }
            
            // Helper function to format date
            function formatDate(dateString) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('ru-RU', options);
            }
        });
    </script>
@endsection