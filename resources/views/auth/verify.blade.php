@extends('client.layout.app')

@section('title', 'Подтверждение адреса электронной почты')

@section('content')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="page">
    <aside class="panel">
        <div class="content">
            <h1 class="title">Подтверждение адреса электронной почты</h1>
            <p class="subtitle">Прежде чем продолжить, пожалуйста, проверьте свою электронную почту на наличие ссылки для подтверждения.</p>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.
                </div>
            @endif

            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn primary">Нажмите здесь, чтобы запросить другую ссылку</button>.
            </form>

            <p class="signup"><a href="{{ route('login') }}">Вернуться на страницу входа</a></p>
        </div>
    </aside>

    <div class="image-login-box">
        <img src="{{ asset('images/login-image.png') }}" class="image-login" alt="">
    </div>
</div>
@endsection