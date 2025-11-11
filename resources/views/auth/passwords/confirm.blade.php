@extends('client.layout.app')

@section('title', 'Подтверждение пароля')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="page">
    <aside class="panel">
        <div class="content">
            <h1 class="title">Подтверждение пароля</h1>
            <p class="subtitle">Пожалуйста, подтвердите ваш пароль, чтобы продолжить</p>

            @if ($errors->any())
                <div class="form-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <label class="field">
                    <span class="label">Пароль</span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Введите пароль">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <button type="submit" class="btn primary">Подтвердить пароль</button>

                @if (Route::has('password.request'))
                    <p class="signup">
                        <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    </p>
                @endif
            </form>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection