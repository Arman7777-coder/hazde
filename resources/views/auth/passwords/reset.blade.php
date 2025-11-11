@extends('client.layout.app')

@section('title', 'Новый пароль')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="page">
    <aside class="panel">
        <div class="content">
            <h1 class="title">Новый пароль</h1>
            <p class="subtitle">Создайте новый пароль</p>

            @if ($errors->any())
                <div class="form-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label class="field">
                    <span class="label">Электронная почта</span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Введите вашу почту">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Новый пароль</span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Создать пароль">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <label class="field">
                    <span class="label">Подтверждение нового пароля</span>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Повторите пароль">
                </label>

                <button type="submit" class="btn primary">Восстановить пароль</button>

                <p class="signup"><a href="{{ route('login') }}">Вернуться на страницу входа</a></p>
            </form>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection