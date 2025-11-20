@extends('client.layout.app')

@section('title', 'Categories')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/categories.css') }}">
<style>
    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .product-link:hover {
        text-decoration: none;
        color: inherit;
    }
    
    .car-container {
        cursor: pointer;
        min-height: 414px; /* Set fixed height for product cards */
        display: flex;
        flex-direction: column;
    }
    
    .loading {
        text-align: center;
        padding: 20px;
    }
    
    .no-products-message {
        text-align: center;
        padding: 20px;
        width: 100%;
    }
    
    .favourite-button {
        transition: transform 0.2s ease;
        cursor: pointer;
        pointer-events: auto; /* Ensure button is clickable */
    }
    
    .favourite-button.liked {
        animation: pulse 0.3s ease;
    }
    
    .favourite-button.liked path {
        fill: #ff0000 !important;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    /* Ensure the image container takes appropriate space */
    .image-container {
        position: relative;
        flex-grow: 1;
    }
    
    .image-car {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
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
        <a href="{{ route('categories.show', ['category' => $category->id]) }}" class="category-card">
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
                <select class="filter-select" name="{{ $filter->name }}" data-filter-id="{{ $filter->id }}">
                    <option value="">{{ $filter->title }}</option>
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

    <div class="filter-result-container" id="products-container">
        @if(isset($approvedProducts) && count($approvedProducts) > 0)
            @foreach($approvedProducts as $product)
            <div class="car-container" data-product-id="{{ $product->id }}">
                <a href="{{ route('client.products.show', $product) }}" class="product-link">
                    <div class="image-container">
                        @if($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="image-car" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/car.png') }}" class="image-car" alt="{{ $product->name }}">
                        @endif
                        <span class="favourite-button {{ in_array($product->id, $likedProducts ?? []) ? 'liked' : '' }}" data-product-id="{{ $product->id }}">
                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.4875 8.07028L7.13438 13.3422C7.36875 13.5609 7.67812 13.6828 8 13.6828C8.32187 13.6828 8.63125 13.5609 8.86563 13.3422L14.5125 8.07028C15.4625 7.18591 16 5.94528 16 4.64841V4.46716C16 2.28278 14.4219 0.420285 12.2688 0.0609095C10.8438 -0.17659 9.39375 0.289035 8.375 1.30778L8 1.68278L7.625 1.30778C6.60625 0.289035 5.15625 -0.17659 3.73125 0.0609095C1.57812 0.420285 0 2.28278 0 4.46716V4.64841C0 5.94528 0.5375 7.18591 1.4875 8.07028Z" fill="#923A3A" />
                            </svg>
                        </span>
                    </div>
                    <h3 class="car-name">{{ $product->name }}</h3>
                    <p class="company-car">
                        <span class="company">{{ $product->user->name ?? 'Поставщик' }}</span>
                        <span class="price">
                            @if($product->price)
                                Цена: {{ number_format($product->price, 0, ',', ' ') }} руб. 
                                @if($product->price_type === 'hourly')
                                    / час
                                @else
                                    / шт.
                                @endif
                            @else
                                Цена: По запросу
                            @endif
                        </span>
                    </p>
                </a>
            </div>
            @endforeach
        @else
            <div class="no-products-message">
                <p>В этой категории пока нет одобренных товаров.</p>
            </div>
        @endif
    </div>
    
    @if(isset($approvedProducts) && method_exists($approvedProducts, 'links'))
        <div class="pagination-container">
            {{ $approvedProducts->links() }}
        </div>
    @endif
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to filter selects
        const filterSelects = document.querySelectorAll('.filter-select');
        const searchInput = document.querySelector('.search-input');
        const locationInput = document.querySelector('.location-input');
        const searchButton = document.querySelector('.search-button');
        const productsContainer = document.getElementById('products-container');
        
        // Add event listeners to favourite buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.favourite-button')) {
                // Prevent the click from propagating to the product link
                e.preventDefault();
                e.stopPropagation();
                
                const button = e.target.closest('.favourite-button');
                const productId = button.getAttribute('data-product-id');
                
                // Add animation class
                button.classList.add('liked');
                
                // Send like request
                fetch(`/products/${productId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Handle response if needed
                    console.log('Like toggled:', data);
                    
                    // Update button state based on like status
                    if (!data.liked) {
                        button.classList.remove('liked');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                
                // Prevent event from bubbling up
                return false;
            }
        });
        
        // Store current filters
        let currentFilters = {};
        let currentSearch = '';
        let currentLocation = '';
        let currentCategoryId = '{{ $selectedCategory->id ?? "" }}';
        
        // Add event listener to search button
        searchButton.addEventListener('click', function() {
            currentSearch = searchInput.value;
            currentLocation = locationInput.value;
            applyFilters();
        });
        
        // Add event listener for Enter key in search inputs
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                currentSearch = searchInput.value;
                currentLocation = locationInput.value;
                applyFilters();
            }
        });
        
        locationInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                currentSearch = searchInput.value;
                currentLocation = locationInput.value;
                applyFilters();
            }
        });
        
        // Add event listeners to filter selects
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                const filterId = this.getAttribute('data-filter-id');
                const optionId = this.value;
                
                if (optionId) {
                    currentFilters[filterId] = optionId;
                } else {
                    delete currentFilters[filterId];
                }
                
                applyFilters();
            });
        });
        
        function applyFilters() {
            // Show loading indicator
            productsContainer.innerHTML = '<div class="loading"><p>Загрузка...</p></div>';
            
            // Prepare filter data
            const filterData = {
                search: currentSearch,
                location: currentLocation,
                filters: currentFilters,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            
            // Send AJAX request
            fetch(`/categories/${currentCategoryId}/filter`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(filterData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateProductList(data);
            })
            .catch(error => {
                console.error('Error:', error);
                productsContainer.innerHTML = '<div class="no-products-message"><p>Произошла ошибка при загрузке товаров.</p></div>';
            });
        }
        
        function updateProductList(data) {
            if (data.products && data.products.length > 0) {
                let productsHtml = '';
                data.products.forEach(product => {
                    const priceText = product.price ? 
                        `Цена: ${parseInt(product.price).toLocaleString('ru-RU')} руб. ${product.price_type === 'hourly' ? '/ час' : '/ шт.'}` : 
                        'Цена: По запросу';
                        
                    const userText = product.user ? product.user.name : 'Поставщик';
                    
                    const imageHtml = product.images && product.images.length > 0 ? 
                        `<img src="/storage/${product.images[0].image_path}" class="image-car" alt="${product.name}">` :
                        `<img src="/images/car.png" class="image-car" alt="${product.name}">`;
                    
                    productsHtml += `
                    <div class="car-container" data-product-id="${product.id}">
                        <a href="/products/${product.id}" class="product-link">
                            <div class="image-container">
                                ${imageHtml}
                                <span class="favourite-button" data-product-id="${product.id}">
                                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.4875 8.07028L7.13438 13.3422C7.36875 13.5609 7.67812 13.6828 8 13.6828C8.32187 13.6828 8.63125 13.5609 8.86563 13.3422L14.5125 8.07028C15.4625 7.18591 16 5.94528 16 4.64841V4.46716C16 2.28278 14.4219 0.420285 12.2688 0.0609095C10.8438 -0.17659 9.39375 0.289035 8.375 1.30778L8 1.68278L7.625 1.30778C6.60625 0.289035 5.15625 -0.17659 3.73125 0.0609095C1.57812 0.420285 0 2.28278 0 4.46716V4.64841C0 5.94528 0.5375 7.18591 1.4875 8.07028Z" fill="#923A3A" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="car-name">${product.name}</h3>
                            <p class="company-car">
                                <span class="company">${userText}</span>
                                <span class="price">${priceText}</span>
                            </p>
                        </a>
                    </div>`;
                });
                productsContainer.innerHTML = productsHtml;
            } else {
                productsContainer.innerHTML = '<div class="no-products-message"><p>В этой категории пока нет одобренных товаров.</p></div>';
            }
        }
    });
</script>
@endsection