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
                <span class="login-span">
                    <a href="{{ route('login') }}" class="login-link">Войти</a>
                    /
                    <a href="{{ url('/seller') }}" class="signup-link">Регистрация</a>
                </span>
        </div>
        <div class="mobile-navbar">
            <a href="" class="hearth-link"><img src="{{ asset('images/hearth.png') }}" class="hearth-icon" alt=""></a>
            <a href="" class="user-link"><img src="{{ asset('images/user.png') }}" class="user-icon" alt=""></a>
            <button class="modal-opener-header"><img src="{{ asset('images/hamburger.png') }}" class="icon-hamburger"
                                                     alt=""></button>
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
                                        <a href="{{ route('categories.show', ['id' => 1]) }}">Авто</a>
                                    </h4>
                                    <p class="desc-mhl">Свадебные кортежи и автомобили премиум-класса.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/home.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 2]) }}">Дома торжеств</a>
                                    </h4>
                                    <p class="desc-mhl">Лучшие рестораны и банкетные залы для вашего события.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/color-swatch.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 3]) }}">Флористика</a>
                                    </h4>
                                    <p class="desc-mhl">Свадебные букеты, декор и цветочное оформление.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/photograph.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 4]) }}">Фото & Видео</a>
                                    </h4>
                                    <p class="desc-mhl">Сохраните лучшие моменты вашего праздника.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/music-note.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 5]) }}">Ведущие & Музыка</a>
                                    </h4>
                                    <p class="desc-mhl">Профессиональные ведущие, диджеи и музыканты.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/cake.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 6]) }}">Кейтеринг</a>
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
                                        <a href="{{ route('categories.show', ['id' => 7]) }}">Всадники</a>
                                    </h4>
                                    <p class="desc-mhl">Эффектное появление и фотосессии на лошадях.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/gift.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 8]) }}">Упаковка приданого</a>
                                    </h4>
                                    <p class="desc-mhl">Современное оформление традиционных подарков.</p>
                                </div>
                            </div>
                            <div>
                                <img src="{{ asset('images/sparkles.png') }}" alt="" class="icon-mhl">
                                <div class="texts-mhl">
                                    <h4 class="mhl-title">
                                        <a href="{{ route('categories.show', ['id' => 9]) }}">Аксессуары</a>
                                    </h4>
                                    <p class="desc-mhl">Пригласительные, бокалы и другие важные мелочи.</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <a href="{{ route('client.home') }}#blog" class="nav-link">Блог</a>
            <a href="{{ route('client.home') }}#about" class="nav-link">О Нас</a>
            <a href="{{ route('client.home') }}#contacts" class="nav-link">Контакты</a>
            <a href="{{ url('/seller') }}" class="nav-link">Стать продавцом</a>
        </nav>
    </div>
</header>
