@extends('client.layout.app')

@section('title', 'Вход — Hasde')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="page">
    <style>button.modal-opener-header{
        display: none !important;
    }</style>
    <aside class="panel">
        <div class="content">
            <h1 class="title">С возвращением!</h1>
            <p class="subtitle">Введите данные для входа в аккаунт</p>

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

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                <label class="field">
                    <span class="label">Электронная почта</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Введите вашу почту" required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Пароль</span>
                    <a class="forgot" href="{{ route('password.request') }}">Забыли пароль?</a>
                    <input type="password" name="password" placeholder="" required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="checkbox">
                    <input type="checkbox" name="remember" class="remember" {{ old('remember') ? 'checked' : '' }} />
                    <span>Запомнить на 30 дней</span>
                </label>

                <button type="submit" class="btn primary">Войти</button>

                <div class="divider"><span>или</span></div>

                <a href="{{ route('social.login', 'google') }}" class="btn ghost">
                    <span class="g-icon"><img src="{{ asset('images/icons8-google 1.png') }}" alt=""></span>
                    Войти через Google
                </a>

                <p class="signup">Нет аккаунта? <a href="{{ route('seller.index') }}">Зарегистрируйтесь</a></p>
            </form>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection
