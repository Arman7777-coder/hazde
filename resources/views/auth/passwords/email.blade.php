@extends('client.layout.app')

@section('title', 'Восстановление пароля')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="page">
    <aside class="panel">
        <div class="content">
            <h1 class="title">Восстановление пароля</h1>
            <p class="subtitle">Введите ваш адрес электронной почты, чтобы получить ссылку для восстановления пароля</p>

            <!-- Отображение ошибок Laravel -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="form-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('password.email') }}">
                @csrf

                <label class="field">
                    <span class="label">Электронная почта</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Введите вашу почту" required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </label>

                <button type="submit" class="btn primary">Отправить ссылку для восстановления пароля</button>

                <p class="signup"><a href="{{ route('login') }}">Вернуться на страницу входа</a></p>
            </form>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection