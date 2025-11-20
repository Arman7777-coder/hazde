@extends('client.layout.app')

@section('title', 'Liked Products')

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
    <a href="{{ route('client.products.liked') }}" class="link-page">Понравившиеся товары</a>
</div>

<section class="car-categories">
    <div class="category-card-title">
        <h2 class="title-car-cat">
            <p class="category-description"><span>П</span>онравившиеся товары</p>
        </h2>
    </div>

    <div class="filter-result-container" id="products-container">
        @if($likedProducts->count() > 0)
            @foreach($likedProducts as $likedProduct)
                @php
                    $product = $likedProduct->product;
                @endphp
                <div class="car-container" data-product-id="{{ $product->id }}">
                    <a href="{{ route('client.products.show', $product) }}" class="product-link">
                        <div class="image-container">
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="image-car" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/car.png') }}" class="image-car" alt="{{ $product->name }}">
                            @endif
                            <span class="favourite-button liked" data-product-id="{{ $product->id }}">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.4875 8.07028L7.13438 13.3422C7.36875 13.5609 7.67812 13.6828 8 13.6828C8.32187 13.6828 8.63125 13.5609 8.86563 13.3422L14.5125 8.07028C15.4625 7.18591 16 5.94528 16 4.64841V4.46716C16 2.28278 14.4219 0.420285 12.2688 0.0609095C10.8438 -0.17659 9.39375 0.289035 8.375 1.30778L8 1.68278L7.625 1.30778C6.60625 0.289035 5.15625 -0.17659 3.73125 0.0609095C1.57812 0.420285 0 2.28278 0 4.46716V4.64841C0 5.94528 0.5375 7.18591 1.4875 8.07028Z" fill="#ff0000" />
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
                <p>У вас пока нет понравившихся товаров.</p>
            </div>
        @endif
    </div>
    
    @if(method_exists($likedProducts, 'links'))
        <div class="pagination-container">
            {{ $likedProducts->links() }}
        </div>
    @endif
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                    // If unliked, remove the product from the list
                    if (!data.liked) {
                        const productContainer = button.closest('.car-container');
                        if (productContainer) {
                            productContainer.remove();
                        }
                        
                        // Check if container is empty and show message
                        const productsContainer = document.getElementById('products-container');
                        if (productsContainer.children.length === 0) {
                            productsContainer.innerHTML = '<div class="no-products-message"><p>У вас пока нет понравившихся товаров.</p></div>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                
                // Prevent event from bubbling up
                return false;
            }
        });
    });
</script>
@endsection