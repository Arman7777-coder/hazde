@extends('seller.layouts.header-sidebar')

@section('title', 'Профиль пользователя')

@section('styles')
    <style>
        .profile-header {
            background: linear-gradient(135deg, #D49494 0%, #923A3A 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D49494 0%, #923A3A 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }
        
        .info-card {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.03);
        }
        
        .info-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #923A3A;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .info-value {
            font-weight: 500;
            text-align: right;
        }
        
        .btn-primary {
            background-color: #923A3A;
            border-color: #923A3A;
        }
        
        .btn-primary:hover {
            background-color: #7a3030;
            border-color: #7a3030;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }
    </style>
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="profile-header">
                <div class="container">
                    <div class="profile-avatar">
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="text-center">
                        <h2>{{ $user->name }}</h2>
                        <p class="mb-1"><i class="mdi mdi-email-outline me-2"></i> {{ $user->email }}</p>
                        @if($user->phone_number)
                        <p class="mb-1"><i class="mdi mdi-phone-outline me-2"></i> {{ $user->phone_number }}</p>
                        @endif
                        @if($user->company_name)
                        <p class="mb-1"><i class="mdi mdi-domain me-2"></i> {{ $user->company_name }}</p>
                        @endif
                        <p><i class="mdi mdi-calendar-outline me-2"></i> Участник с {{ $user->created_at->format('d.m.Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Информация о пользователе</h3>
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil me-1"></i> Редактировать профиль
                        </a>
                    </div>

                    <div class="info-card">
                        <h3>Основная информация</h3>
                        <div class="info-row">
                            <span class="info-label">Имя:</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Компания:</span>
                            <span class="info-value">{{ $user->company_name ?? 'Не указана' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Телефон:</span>
                            <span class="info-value">{{ $user->phone_number ?? 'Не указан' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Дата регистрации:</span>
                            <span class="info-value">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3>Статус аккаунта</h3>
                        <div class="info-row">
                            <span class="info-label">Роль:</span>
                            <span class="info-value">
                                @if($user->hasRole('seller'))
                                    Продавец
                                @elseif($user->hasRole('admin'))
                                    Администратор
                                @else
                                    Пользователь
                                @endif
                            </span>
                        </div>
                        @if($user->hasRole('seller'))
                        <div class="info-row">
                            <span class="info-label">Статус подписки:</span>
                            <span class="info-value">
                                @if($user->subscription && $user->subscription->payment_status === 'paid')
                                    <span class="text-success">Активна</span>
                                @else
                                    <span class="text-warning">Не активна</span>
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
