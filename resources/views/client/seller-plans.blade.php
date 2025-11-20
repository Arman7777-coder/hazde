@extends('client.layout.app')

@section('title', 'Стать продавцом - Выбор тарифа')

@section('content')
    <div class="page-name-link">
        <a href="{{ route('client.home') }}" class="link-page">Главная</a>
        /
        <a href="{{ route('seller.index') }}" class="link-page">Стать продавцом</a>
    </div>

    <section class="tariff-plans">
        <h1 class="tariff-title"><span>Т</span>арифные планы</h1>

        <div class="tarif-card-wrapper">
            <div class="tariff-cards">
                @foreach($plans as $index => $plan)
                <div class="card-tarif {{ $plan->name === 'Базовый' ? 'free-tarif' : ($plan->name === 'Расширенный' ? 'expanded-tarif' : 'pro-tarif') }} {{ $index == 1 ? 'active' : '' }}" data-plan-id="{{ $plan->id }}">
                    <h1 class="tariff-name">{{ ucfirst($plan->name) }}</h1>
                    <div class="tarif-card-inner">
                        <h3 class="tarif-price">
                            @if($plan->price == 0)
                                бесплатно
                            @else
                                {{ number_format($plan->price, 0, '.', ' ') }}₽/в мес.
                            @endif
                        </h3>
                        <ul class="tarif-features">
                            <li class="tarif-feature"><img src="{{ asset('images/list-ul.png') }}" class="icon-list" alt="">Всё, что в
                                базовом тарифе</li>
                            <li class="tarif-feature"><img src="{{ asset('images/list-ul.png') }}" class="icon-list" alt="">
                                @if($plan->max_products)
                                    До {{ $plan->max_products }} услуг
                                @else
                                    Неограниченное количество услуг
                                @endif
                            </li>
                            <li class="tarif-feature"><img src="{{ asset('images/list-ul.png') }}" class="icon-list" alt="">Расширенный
                                профиль</li>
                            <li class="tarif-feature"><img src="{{ asset('images/list-ul.png') }}" class="icon-list" alt="">Приоритет в
                                поиске</li>
                        </ul>
                        <button class="tarif-button" data-plan-id="{{ $plan->id }}">Выбрать</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="plan-selection-actions">
            <button id="continue-button" class="btn btn-primary">Продолжить регистрацию</button>
        </div>
    </section>

    <section class="registration-form" style="display: none;">
        <h1 class="tariff-title"><span>Ф</span>орма регистрации</h1>
        <div class="form-fields">
            <form id="registration-form" action="{{ route('seller.register') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" id="selected-plan-id">
                <div class="form-first-col">
                    <div class="input-form">
                        <label for="first-name" class="form-label">Имя</label>
                        <input type="text" id="first-name" placeholder="Введите ваше имя" name="first_name"
                               class="form-input" required>
                    </div>
                    <div class="input-form">
                        <label for="last-name" class="form-label">Фамилия</label>
                        <input type="text" id="last-name" placeholder="Введите вашу фамилию" name="last_name"
                               class="form-input" required>
                    </div>
                    <div class="input-form">
                        <label for="email" class="form-label">Электронная почта</label>
                        <input type="email" id="email" placeholder="Введите ваш e-mail" name="email"
                               class="form-input" required>
                    </div>
                    <div class="input-form">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="text" id="phone" placeholder="Введите ваш номер телефона" name="phone"
                               class="form-input" required>
                    </div>
                    <div class="input-form">
                        <label for="service-description" class="form-label">Описание услуги</label>
                        <input type="text" id="service-description"
                               placeholder="Кратко расскажите о своей услуге (до 300 символов)" name="service_description"
                               class="form-input" required maxlength="300">
                    </div>
                    <div class="upload-box">
                        <label for="file-upload" class="upload-label">
                            <div class="upload-text">
                                <span class="form-label">Добавить фото / логотип</span>
                                <span class="form-input">Загрузите изображение или логотип вашей услуги</span>
                            </div>
                            <div class="upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
                                    <path d="M7 9l5-5 5 5" />
                                    <path d="M12 4v12" />
                                </svg>
                            </div>
                        </label>
                        <input id="file-upload" type="file" class="upload-input" name="logo" />
                    </div>

                </div>
                <div class="second-column">
                    <div class="input-form">
                        <label for="company-name" class="form-label">Название компании / услуги</label>

                        <input type="text" id="company-name" name="company_name" class="form-input"
                               placeholder="Введите название вашей компании или услуги" required>
                    </div>
                    <div class="category-section">
                        <label class="category-label">Категория услуги</label>
                        <p class="category-subtext">Выберите категорию, в которой хотите размещаться:<svg width="16"
                                                                                                          height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 7L7.5 12L3 7" stroke="#D49494" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round" />
                            </svg>
                        </p>

                        <div class="category-grid">
                            <button type="button" class="category-item" data-category="Авто">Авто</button>
                            <button type="button" class="category-item" data-category="Фото & Видео">Фото & Видео</button>
                            <button type="button" class="category-item" data-category="Дома торжеств">Дома торжеств</button>
                            <button type="button" class="category-item" data-category="Ведущие & Музыка">Ведущие & Музыка</button>
                            <button type="button" class="category-item" data-category="Флористика">Флористика</button>
                            <button type="button" class="category-item" data-category="Кейтеринг">Кейтеринг</button>
                            <button type="button" class="category-item" data-category="Всадники">Всадники</button>
                            <button type="button" class="category-item" data-category="Упаковка приданого">Упаковка приданого</button>
                            <button type="button" class="category-item" data-category="Аксессуары">Аксессуары</button>
                        </div>
                        <input type="hidden" name="category" id="selected-category">
                    </div>
                </div>
                <div class="form-button">
                    <button type="submit" class="form-submit-button"><span class="text-submit-button">Создать
                            профиль</span><span class="svg-button-submit"><svg width="32" height="32"
                                                                               viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1_2251)">
                                    <path
                                        d="M18.9999 25.9999C18.8683 26.0007 18.7379 25.9755 18.616 25.9257C18.4942 25.8759 18.3834 25.8026 18.2899 25.7099C18.1962 25.617 18.1218 25.5064 18.071 25.3845C18.0203 25.2627 17.9941 24.8679 17.9941 24.9999C17.9941 24.8679 18.0203 24.7372 18.071 24.6154C18.1218 24.4935 18.1962 24.3829 18.2899 24.2899L26.5899 15.9999L18.2899 7.70994C18.1016 7.52164 17.9958 7.26624 17.9958 6.99994C17.9958 6.73364 18.1016 6.47825 18.2899 6.28994C18.4782 6.10164 18.7336 5.99585 18.9999 5.99585C19.2662 5.99585 19.5216 6.10164 19.7099 6.28994L28.7099 15.2899C28.8037 15.3829 28.8781 15.4935 28.9288 15.6154C28.9796 15.7372 29.0057 15.8679 29.0057 15.9999C29.0057 16.132 28.9796 16.2627 28.9288 16.3845C28.8781 16.5064 28.8037 16.617 28.7099 16.7099L19.7099 25.7099C19.6165 25.8026 19.5057 25.8759 19.3838 25.9257C19.262 25.9755 19.1315 26.0007 18.9999 25.9999Z"
                                        fill="#923A3A" />
                                    <path
                                        d="M28 17H4C3.73478 17 3.48043 16.8946 3.29289 16.7071C3.10536 16.5196 3 16.2652 3 16C3 15.7348 3.10536 15.4804 3.29289 15.2929C3.48043 15.1054 3.73478 15 4 15H28C28.2652 15 28.5196 15.1054 28.7071 15.2929C28.8946 15.4804 29 15.7348 29 16C29 16.2652 28.8946 16.5196 28.7071 16.7071C28.5196 16.8946 28.2652 17 28 17Z"
                                        fill="#923A3A" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_1_2251">
                                        <rect width="32" height="32" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span></button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('styles')
<style>
    @font-face {
        font-family: 'Good Vibes Pro';
        src: url('{{ asset('fonts/GoodVibesCyr.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    
    .page-name-link {
        margin-top: 46px !important;
        max-width: 1284px;
        width: calc(100% - 20px);
        margin: auto;
        display: flex;
        gap: 5px;
        font-family: Arial;
        font-weight: 400;
        font-size: 14px;
        line-height: 20px;
        color: var(--Vintage-Rose, #D1B5B8);
    }

    a.link-page {
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        font-size: 12px;
        margin-top: 2px;
        display: block;
        text-decoration: none;
        line-height: 140%;
        letter-spacing: 0%;
        color: var(--Button-pink, #D49494);
    }

    h1.tariff-title {
        max-width: fit-content;
        margin: auto;
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        margin-bottom: 69px;
        font-size: 48px;
        line-height: 140%;
        text-align: center;
        color: var(--Dark-red, #923A3A);
    }

    .tariff-title span {
        font-family: 'Good Vibes Pro';
        font-weight: 400;
        font-style: italic;
        font-size: 70px;
        leading-trim: NONE;
        line-height: 140%;
        letter-spacing: 0%;
        text-align: center;
    }

    .tarif-card-wrapper {
        position: relative;
        margin-bottom: 50px;
    }

    .tariff-cards {
        display: flex;
        max-width: 1305px;
        margin: auto;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .card-tarif {
        max-width: 400px;
        width: 100%;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .card-tarif:hover {
        transform: translateY(-5px);
    }

    .card-tarif.free-tarif .tarif-card-inner {
        background: #F4EDD9;
    }

    h1.tariff-name {
        font-family: Good Vibes Pro;
        font-weight: 400;
        font-style: Regular;
        font-size: 72px;
        leading-trim: NONE;
        line-height: 140%;
        letter-spacing: 0%;
        text-align: center;
        margin: 0;
        color: var(--Dark-red, #923A3A);
        text-transform: capitalize;
    }

    h3.tarif-price {
        font-family: URW Bookman;
        font-weight: 300;
        font-style: italic;
        font-size: 40px;
        margin: 0;
        line-height: 140%;
        letter-spacing: 0%;
        text-align: center;
        color: #8D2B2B;
    }

    button.tarif-button {
        margin-top: auto !important;
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        font-size: 20px;
        color: var(--Dark-red, #923A3A);
        line-height: 140%;
        background: none;
        border: 1px solid var(--Dark-red, #923A3A);
        border-radius: 10px;
        padding: 9px 55px;
        width: fit-content;
        margin: 0 auto;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button.tarif-button:hover {
        background-color: var(--Dark-red, #923A3A);
        color: white;
    }

    li.tarif-feature {
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        font-size: 20px;
        leading-trim: NONE;
        line-height: 140%;
        letter-spacing: 0%;
        color: #4A4942;
        display: flex;
        gap: 8px;
        padding-top: 6px;
        padding-bottom: 6px;
        border-bottom: 1px solid #4A4942;
        align-items: center;
    }

    ul.tarif-features {
        list-style: none;
        padding-left: 0;
    }

    .tarif-card-inner {
        padding: 18px 40px;
        min-height: 458px;
        display: flex;
        flex-direction: column;
        background: var(--Button-pink, #D49494);
        border-radius: 20px;
    }

    .expanded-tarif .tarif-card-inner button {
        background: #8D2B2B;
        color: #EFECE1;
    }

    .card-tarif.expanded-tarif .tarif-card-inner > ul > li {
        color: #F4EDD9;
    }

    .pro-tarif .tarif-card-inner {
        background: #F4EDD9;
    }

    /* Active plan styling */
    .card-tarif.active .tarif-card-inner {
        background-color: #D49494 !important;
        color: #F4EDD9;
        box-shadow: 0 0 20px rgba(146, 58, 58, 0.5);
        border: 2px solid #8D2B2B;
    }

    .card-tarif.active .tarif-feature {
        color: #F4EDD9;
    }
    
    .card-tarif.active .tarif-button {
        background-color: #8D2B2B;
        color: #F4EDD9;
    }

    .plan-selection-actions {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 50px;
    }

    #continue-button {
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        font-size: 24px;
        color: var(--Dark-red, #923A3A);
        background: none;
        border: 2px solid var(--Dark-red, #923A3A);
        border-radius: 10px;
        padding: 12px 40px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #continue-button:hover {
        background-color: var(--Dark-red, #923A3A);
        color: white;
    }

    .category-section {
        padding: 20px;
        border-radius: 8px;
        padding: 0;
    }

    .category-label {
        display: block;
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        max-width: 520px;
        font-size: 18px;
        color: var(--Dark-red, #923A3A);
        line-height: 140%;
        letter-spacing: 0%;
        width: 100%;
        margin-left: auto;
    }

    .category-subtext {
        font-family: URW Bookman;
        font-weight: 300;
        display: flex;
        font-size: 16px;
        line-height: 140%;
        color: #923A3A80;
        margin: 0 0 10px 0;
        border-bottom: 1px solid var(--Dark-red, #923A3A);
        padding-bottom: 6px;
        max-width: 520px;
        width: 100%;
        margin-left: auto;
        justify-content: space-between;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 10px 10px;
    }

    .category-item {
        font-family: URW Bookman;
        font-weight: 300;
        font-style: italic;
        font-size: 24px;
        padding: 10px 10px;
        line-height: 140%;
        padding-bottom: 22px !important;
        background: none;
        border-radius: 5px;
        text-align: left;
        border: 1px solid var(--Dark-red, #923A3A);
        color: var(--Dark-red, #923A3A);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .category-item:hover {
        background-color: #f8eae3;
    }

    .category-item:active,
    .category-item.selected {
        background-color: #b94d4d;
        color: #fff;
    }

    section.registration-form > .tariff-title {
        margin-top: 114px;
    }

    .form-fields form {
        display: flex;
        justify-content: center;
        width: 100%;
        gap: 63px;
        flex-wrap: wrap;
        max-width: 1410px;
        margin: auto;
    }

    .input-form {
        display: flex;
        max-width: 520px;
        flex-direction: column;
        width: 100%;
        margin-left: auto;
    }

    label.form-label {
        font-family: URW Bookman;
        font-weight: 400;
        font-style: italic;
        font-size: 18px;
        color: var(--Dark-red, #923A3A);
        line-height: 140%;
        max-width: 520px;
        width: 100%;
    }

    .form-input {
        background: none;
        border: none;
        max-width: 520px;
        border-bottom: 1px solid var(--Dark-red, #923A3A);
        padding-bottom: 6px;
    }

    .form-first-col {
        display: flex;
        max-width: 520px;
        width: 100%;
        background: none;
        flex-direction: column;
        gap: 28px;
    }

    .upload-box {
        width: 100%;
        position: relative;
    }

    .upload-label {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        cursor: pointer;
        border-bottom: 1px solid #b85c5c;
        padding-bottom: 6px;
        color: #9b5a4a;
        transition: all 0.2s ease;
    }

    .upload-label:hover {
        color: #b85c5c;
    }

    .upload-text {
        display: flex;
        flex-direction: column;
    }

    .upload-icon {
        display: flex;
        align-items: center;
        color: #b85c5c;
    }

    .upload-input {
        display: none;
    }

    .upload-text .form-input {
        padding-bottom: 0;
        border-bottom: 0;
        font-family: URW Bookman;
        font-weight: 300;
        font-style: Light;
        font-size: 16px;
        leading-trim: NONE;
        line-height: 140%;
        letter-spacing: 0%;
        color: #923A3A80;
    }

    .second-column {
        max-width: 613px;
        width: 100%;
    }

    .second-column .input-form:nth-child(1) {
        margin-bottom: 17px;
    }

    button.form-submit-button {
        background: none;
        padding: 0;
        display: flex;
        border: none;
        align-items: center;
        cursor: pointer;
    }

    span.text-submit-button {
        font-family: URW Bookman;
        font-weight: 300;
        border: 0.91px solid var(--Dark-red, #923A3A);
        font-size: 25px;
        max-width: 143px;
        line-height: 22px;
        padding: 5.5px 32px !important;
        width: 100%;
        text-align: center;
        display: block;
        height: 100%;
        border-radius: 5px;
        color: var(--Dark-red, #923A3A);
        box-sizing: unset;
    }

    span.svg-button-submit {
        display: flex;
        height: 56px;
        border: 0.91px solid var(--Dark-red, #923A3A);
        border-radius: 100%;
        width: 56px;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .tarif-card-wrapper {
            overflow: hidden;
            position: relative;
        }
        
        .page-name-link {
            display: none;
        }
        
        button.form-submit-button {
            margin-top: 50px;
            margin-bottom: 89px;
        }
        
        h1.tariff-name {
            max-width: 345px;
            width: 100%;
        }
        
        .tariff-cards {
            display: flex;
            transition: transform 0.4s ease;
            flex-wrap: nowrap;
            width: 1500px;
            justify-content: flex-start;
            gap: 20px;
        }

        .card-tarif {
            box-sizing: border-box;
        }

        .card-tarif.free-tarif {
            margin-left: 14px;
        }

        .tarif-card-inner {
            max-width: 315px !important;
            width: 100%;
            padding: 15px;
        }

        /* Progress bar */
        .progressbar-container {
            width: calc(100% - 30px);
            height: 6px;
            background-color: #e3cbbf;
            border-radius: 3px;
            margin-top: 14px !important;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            margin-top: 24px !important;
            margin: auto;
        }
        
        h1.tariff-title {
            height: fit-content;
            line-height: 0;
            margin: 0;
            height: 125px;
        }

        section.registration-form > .tariff-title {
            margin: 52px auto;
        }
        
        .progressbar-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background-color: #a73c3c;
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .form-fields form {
            width: calc(100% - 40px);
            gap: 20px;
        }
        
        .category-item {
            max-width: 300px;
        }
        
        /* Active plan styling for mobile */
        .card-tarif.active .tarif-card-inner {
            background-color: #D49494 !important;
            color: #F4EDD9;
        }

        .card-tarif.active .tarif-feature {
            color: #F4EDD9;
        }
        
        .card-tarif.active .tarif-button {
            background-color: #8D2B2B;
            color: #F4EDD9;
        }
    }

    @media (min-width: 769px) {
        .progressbar-container {
            display: none;
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.tarif-card-wrapper');
    const container = wrapper.querySelector('.tariff-cards');
    const cards = container.querySelectorAll('.card-tarif');
    const continueButton = document.getElementById('continue-button');
    const registrationForm = document.querySelector('.registration-form');
    const tariffPlansSection = document.querySelector('.tariff-plans');

    // Set default selected plan in form
    const activeCard = document.querySelector('.card-tarif.active');
    if (activeCard) {
        document.getElementById('selected-plan-id').value = activeCard.getAttribute('data-plan-id');
    }

    // Add active state to selected plan
    const planButtons = document.querySelectorAll('.tarif-button');
    planButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            // Remove active class from all cards
            cards.forEach(card => {
                card.classList.remove('active');
            });
            
            // Add active class to clicked card
            const card = this.closest('.card-tarif');
            card.classList.add('active');
            
            // Set the selected plan ID in the form
            document.getElementById('selected-plan-id').value = this.getAttribute('data-plan-id');
        });
    });

    // Add click event to cards themselves
    cards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            cards.forEach(c => {
                c.classList.remove('active');
            });
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Set the selected plan ID in the form
            const planId = this.getAttribute('data-plan-id');
            document.getElementById('selected-plan-id').value = planId;
        });
    });

    // Continue button functionality
    continueButton.addEventListener('click', function() {
        const selectedPlanId = document.getElementById('selected-plan-id').value;
        if (!selectedPlanId) {
            alert('Пожалуйста, выберите тарифный план');
            return;
        }
        
        // Hide tariff plans section and show registration form
        tariffPlansSection.style.display = 'none';
        registrationForm.style.display = 'block';
        
        // Scroll to registration form
        registrationForm.scrollIntoView({ behavior: 'smooth' });
    });

    // Category selection
    document.querySelectorAll('.category-item').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.category-item').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById('selected-category').value = btn.getAttribute('data-category');
        });
    });

    if (!container || window.innerWidth > 768) return;

    const slideWidth = 420; //  your fixed pixel width
    let currentIndex = 0;
    const total = cards.length;

    // Create progress bar
    const progressContainer = document.createElement('div');
    progressContainer.classList.add('progressbar-container');
    const progressFill = document.createElement('div');
    progressFill.classList.add('progressbar-fill');
    progressContainer.appendChild(progressFill);
    wrapper.appendChild(progressContainer);

    // Update progress + move slides
    const updateProgress = (index) => {
        currentIndex = index;
        container.style.transform = `translateX(-${index * slideWidth}px)`;
        progressFill.style.width = `${((index + 1) / total) * 100}%`;
    };

    // Clickable progress bar
    progressContainer.addEventListener('click', (e) => {
        const rect = progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const ratio = clickX / rect.width;
        const index = Math.floor(ratio * total);
        updateProgress(index);
    });

    // Swipe support
    let startX = 0;
    container.addEventListener('touchstart', (e) => startX = e.touches[0].clientX);
    container.addEventListener('touchend', (e) => {
        const endX = e.changedTouches[0].clientX;
        if (startX - endX > 50 && currentIndex < total - 1) updateProgress(currentIndex + 1);
        else if (endX - startX > 50 && currentIndex > 0) updateProgress(currentIndex - 1);
    });

    // Initialize
    updateProgress(0);
});
</script>
@endsection