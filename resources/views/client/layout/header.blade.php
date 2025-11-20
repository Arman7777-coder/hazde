<header>
    <div class="upper-logo-container">
        <div class="searchbar-container">
            <img src="{{ asset('images/search.png') }}" class="search-icon" alt="">
            <input type="text" class="searchbar" placeholder="Search....">
        </div>
        <div class="logo-container">
            <a href="{{ route('client.home') }}">
                <img src="{{ asset('images/hazde-logo.png') }}" class="logo" alt="Hazde Logo">
            </a>
        </div>
        <div class="login-links">
            @auth
                <!-- User is logged in - show account button -->
                <a href="{{ route('seller.products.index') }}" class="login-link">Аккаунт</a>
            @else
                <!-- User is not logged in - show login/register buttons -->
                <span class="login-span">
                    <a href="{{ route('login') }}" class="login-link">Войти</a>
                    /
                    <a href="{{ url('/seller') }}" class="signup-link">Регистрация</a>
                </span>
            @endauth
        </div>
        <div class="mobile-navbar">
            <a href="{{ route('client.products.liked') }}" class="hearth-link">
                <img src="{{ asset('images/hearth.png') }}" class="hearth-icon" alt="">
            </a>
            @auth
                <!-- User is logged in - show account button -->
                <a href="{{ route('seller.products.index') }}" class="user-link"><img src="{{ asset('images/user.png') }}" class="user-icon" alt=""></a>
            @else
                <!-- User is not logged in - show login button -->
                <a href="{{ route('login') }}" class="user-link"><img src="{{ asset('images/user.png') }}" class="user-icon" alt=""></a>
            @endauth
            <button class="modal-opener-header"
                    onclick="document.getElementById('menu-mobile').classList.add('active')"><img
                    src="images/hamburger.png" class="icon-hamburger" alt=""></button>
        </div>
    </div>
    <div class="menu-lower">
        <nav class="navbar-header">
            <a href="{{ route('client.home') }}" class="nav-link">Главная</a>
            <div class="nav-link dropdown">
                <span>Категории <img src="{{ asset('images/cheveron-up.png') }}" class="icon-opener" alt=""></span>
                <div class="menu-hover">
                    <div class="best-day">
                        <h2 class="title-best-day">Найдите все, что нужно для идеального дня</h2>
                        <div class="menu-header-links">
                            <div>
                                <img src="{{ asset('images/truck.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 1]) }}">Авто</a>
                                    </h4>
                                    <p class="desc-mhl">Свадебные кортежи и автомобили премиум-класса.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/home.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 2]) }}">Дома торжеств</a>
                                    </h4>
                                    <p class="desc-mhl">Лучшие рестораны и банкетные залы для вашего события.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/color-swatch.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 3]) }}">Флористика</a>
                                    </h4>
                                    <p class="desc-mhl">Свадебные букеты, декор и цветочное оформление.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/photograph.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 4]) }}">Фото & Видео</a>
                                    </h4>
                                    <p class="desc-mhl">Сохраните лучшие моменты вашего праздника.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/music-note.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 5]) }}">Ведущие & Музыка</a>
                                    </h4>
                                    <p class="desc-mhl">Профессиональные ведущие, диджеи и музыканты.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/cake.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 6]) }}">Кейтеринг</a>
                                    </h4>
                                    <p class="desc-mhl">Изысканные блюда и выездное обслуживание.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="best-day gray-back">
                        <h2 class="title-best-day">Важные детали для вашего праздника</h2>
                        <div class="menu-header-links">
                            <div>
                                <img src="{{ asset('images/emoji-happy.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 7]) }}">Всадники</a>
                                    </h4>
                                    <p class="desc-mhl">Эффектное появление и фотосессии на лошадях.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/gift.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 8]) }}">Упаковка приданого</a>
                                    </h4>
                                    <p class="desc-mhl">Современное оформление традиционных подарков.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/sparkles.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['category' => 9]) }}">Аксессуары</a>
                                    </h4>
                                    <p class="desc-mhl">Пригласительные, бокалы и другие важные мелочи.</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <a href="{{ route('client.products.liked') }}" class="nav-link">Избранное</a>
{{--            <a href="{{ route('client.home') }}#blog" class="nav-link">Блог</a>--}}
            <a href="{{ route('client.home') }}#about" class="nav-link">О Нас</a>
            <a href="{{ route('client.home') }}#contacts" class="nav-link">Контакты</a>
            <a href="{{ route('seller.index') }}" class="nav-link">Стать продавцом</a>
        </nav>
    </div>
    <div class="menu-mobile" id="menu-mobile">
        <div class="buttons-mobile-menu">
            <button class="category-mobile-reverse" id="categori-closer"
                    onclick="document.getElementById('categorys-mobile').classList.toggle('active');document.getElementById('categori-closer').classList.toggle('active');document.body.style.overflow='hidden'">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1_2018)">
                        <path
                            d="M18.9999 26.0002C18.8683 26.0009 18.7379 25.9757 18.616 25.926C18.4942 25.8762 18.3834 25.8029 18.2899 25.7102C18.1962 25.6172 18.1218 25.5066 18.071 25.3848C18.0203 25.2629 17.9941 25.1322 17.9941 25.0002C17.9941 24.8682 18.0203 24.7375 18.071 24.6156C18.1218 24.4937 18.1962 24.3831 18.2899 24.2902L26.5899 16.0002L18.2899 7.71019C18.1016 7.52188 17.9958 7.26649 17.9958 7.00019C17.9958 6.73388 18.1016 6.47849 18.2899 6.29019C18.4782 6.10188 18.7336 5.99609 18.9999 5.99609C19.2662 5.99609 19.5216 6.10188 19.7099 6.29019L28.7099 15.2902C28.8037 15.3831 28.8781 15.4937 28.9288 15.6156C28.9796 15.7375 29.0057 15.8682 29.0057 16.0002C29.0057 16.1322 28.9796 16.2629 28.9288 16.3848C28.8781 16.5066 28.8037 16.6172 28.7099 16.7102L19.7099 25.7102C19.6165 25.8029 19.5057 25.8762 19.3838 25.926C19.262 25.9757 19.1315 26.0009 18.9999 26.0002Z"
                            fill="#923A3A" />

                    </g>
                    <defs>
                        <clipPath id="clip0_1_2018">
                            <rect width="32" height="32" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </button>
            <button class="button-mobile-closer"
                    onclick="document.getElementById('menu-mobile').classList.remove('active');document.body.style.overflow='visible'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path class="close-menu-burger" fill="none" fill-rule="evenodd" stroke="#fff"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 9.5l8-8-8 8-8-8 8 8zm0 0l8 8-8-8-8 8 8-8z"></path>
                </svg>
            </button>
        </div>
        <ul class="list-links-mobile-menu">
            <li class="li-links-wrapper-mobile"><a href="{{ route('client.home') }}" class="link-mobile-menu">Главная</a></li>
            <li class="li-links-wrapper-mobile" id="categorys-mobile">
                <a href="{{ route('categories.index') }}" class="link-mobile-menu">Категории</a>
                <button class="category-mobile-opener"
                        onclick="document.getElementById('categorys-mobile').classList.toggle('active');document.getElementById('categori-closer').classList.toggle('active')">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_2018)">
                            <path
                                d="M18.9999 26.0002C18.8683 26.0009 18.7379 25.9757 18.616 25.926C18.4942 25.8762 18.3834 25.8029 18.2899 25.7102C18.1962 25.6172 18.1218 25.5066 18.071 25.3848C18.0203 25.2629 17.9941 25.1322 17.9941 25.0002C17.9941 24.8682 18.0203 24.7375 18.071 24.6156C18.1218 24.4937 18.1962 24.3831 18.2899 24.2902L26.5899 16.0002L18.2899 7.71019C18.1016 7.52188 17.9958 7.26649 17.9958 7.00019C17.9958 6.73388 18.1016 6.47849 18.2899 6.29019C18.4782 6.10188 18.7336 5.99609 18.9999 5.99609C19.2662 5.99609 19.5216 6.10188 19.7099 6.29019L28.7099 15.2902C28.8037 15.3831 28.8781 15.4937 28.9288 15.6156C28.9796 15.7375 29.0057 15.8682 29.0057 16.0002C29.0057 16.1322 28.9796 16.2629 28.9288 16.3848C28.8781 16.5066 28.8037 16.6172 28.7099 16.7102L19.7099 25.7102C19.6165 25.8029 19.5057 25.8762 19.3838 25.926C19.262 25.9757 19.1315 26.0009 18.9999 26.0002Z"
                                fill="#923A3A" />
                            <path
                                d="M28 17H4C3.73478 17 3.48043 16.8946 3.29289 16.7071C3.10536 16.5196 3 16.2652 3 16C3 15.7348 3.10536 15.4804 3.29289 15.2929C3.48043 15.1054 3.73478 15 4 15H28C28.2652 15 28.5196 15.1054 28.7071 15.2929C28.8946 15.4804 29 15.7348 29 16C29 16.2652 28.8946 16.5196 28.7071 16.7071C28.5196 16.8946 28.2652 17 28 17Z"
                                fill="#923A3A" />
                        </g>
                        <defs>
                            <clipPath id="clip0_1_2018">
                                <rect width="32" height="32" fill="white" />
                            </clipPath>
                        </defs>
                    </svg></button>
                <div class="categories-opening-menu-mobile">
                    <a href="{{ route('categories.show', ['category' => 1]) }}" class="category-mobile-link">Авто</a>
                    <a href="{{ route('categories.show', ['category' => 2]) }}" class="category-mobile-link">Дома торжеств</a>
                    <a href="{{ route('categories.show', ['category' => 3]) }}" class="category-mobile-link">Флористика</a>
                    <a href="{{ route('categories.show', ['category' => 4]) }}" class="category-mobile-link">Фото & Видео</a>
                    <a href="{{ route('categories.show', ['category' => 5]) }}" class="category-mobile-link">Ведущие & Музыка</a>
                    <a href="{{ route('categories.show', ['category' => 6]) }}" class="category-mobile-link">Кейтеринг</a>
                    <a href="{{ route('categories.show', ['category' => 7]) }}" class="category-mobile-link">Всадники</a>
                    <a href="{{ route('categories.show', ['category' => 8]) }}" class="category-mobile-link">Упаковка приданого</a>
                    <a href="{{ route('categories.show', ['category' => 9]) }}" class="category-mobile-link">Аксессуары</a>
                </div>
            </li>
            <li class="li-links-wrapper-mobile"><a href="{{ route('client.products.liked') }}" class="link-mobile-menu">Избранное</a></li>
            <li class="li-links-wrapper-mobile"><a href="{{ route('client.home') }}#about" class="link-mobile-menu">О Нас</a></li>
            <li class="li-links-wrapper-mobile"><a href="{{ route('seller.index')}}" class="link-mobile-menu">Стать продавцом</a></li>
        </ul>
    </div>
</header>
