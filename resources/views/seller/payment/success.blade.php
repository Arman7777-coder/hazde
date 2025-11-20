@extends('client.layout.app')

@section('title', 'Оплата прошла успешно')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Оплата прошла успешно</div>
                <div class="card-body">
                    <h5>Спасибо за вашу оплату!</h5>
                    <p>Ваш платеж был успешно обработан. Теперь вы можете создать учетную запись продавца.</p>
                    
                    <a href="{{ route('seller.create.user', ['subscription' => $subscriptionId ?? 0]) }}" class="btn btn-primary">Создать учетную запись</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection