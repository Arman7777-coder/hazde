@extends('client.layout.app')

@section('title', 'Регистрация — Hasde')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="page">
    <aside class="panel">
        <div class="content">
            <h1 class="title">Регистрация</h1>

            <!-- Laravel սխալների ցուցադրում -->
            @if ($errors->any())
                <div class="form-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('register') }}">
                @csrf

                <label class="field">
                    <span class="label">Имя</span>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Введите ваше имя" required />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Электронная почта</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Введите вашу почту" required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Пароль</span>
                    <input type="password" name="password" placeholder="Создать пароль" required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Подтверждение пароля</span>
                    <input type="password" name="password_confirmation" placeholder="Повторите пароль" required />
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="checkbox">
                    <input type="checkbox" name="terms" class="remember" {{ old('terms') ? 'checked' : '' }} />
                    <span>Я согласен с условиями и политикой конфиденциальности</span>
                </label>

                <button type="submit" class="btn primary">Зарегистрироваться</button>

                <div class="divider"><span>или</span></div>

                <a href="{{ route('social.login', 'google') }}" class="btn ghost">
                    <span class="g-icon"><img src="{{ asset('images/icons8-google 1.png') }}" alt=""></span>
                    Войти через Google
                </a>

                <p class="signup">Уже есть аккаунт? <a href="{{ route('login') }}">Войдите</a></p>
            </form>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection
