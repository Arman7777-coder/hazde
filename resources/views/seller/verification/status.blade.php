@extends('seller.layouts.header-sidebar')

@section('title', 'Статус верификации')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Статус верификации</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Ваш статус верификации</h4>
                                
                                @if($verification)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-{{ $verification->status == 'approved' ? 'success' : ($verification->status == 'rejected' ? 'danger' : 'warning') }} text-white">
                                                <div class="card-body">
                                                    <h5 class="card-title">Статус: {{ ucfirst($verification->status) }}</h5>
                                                    @if($verification->status == 'approved')
                                                        <p class="card-text">Поздравляем! Ваша учетная запись продавца верифицирована.</p>
                                                    @elseif($verification->status == 'rejected')
                                                        <p class="card-text">К сожалению, ваш запрос на верификацию был отклонен.</p>
                                                        @if($verification->admin_notes)
                                                            <p class="card-text"><strong>Причина:</strong> {{ $verification->admin_notes }}</p>
                                                        @endif
                                                    @else
                                                        <p class="card-text">Ваш запрос на верификацию находится на рассмотрении. Пожалуйста, подождите.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Информация о запросе</h5>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Тип документа</th>
                                                    <td>{{ $verification->document_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Имя</th>
                                                    <td>{{ $verification->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Фамилия</th>
                                                    <td>{{ $verification->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Номер документа</th>
                                                    <td>{{ $verification->id_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Дата подачи</th>
                                                    <td>{{ $verification->created_at->format('d.m.Y H:i') }}</td>
                                                </tr>
                                                @if($verification->verified_at)
                                                    <tr>
                                                        <th>Дата верификации</th>
                                                        <td>{{ $verification->verified_at->format('d.m.Y H:i') }}</td>
                                                    </tr>
                                                @endif
                                                @if($verification->admin_notes && $verification->status == 'rejected')
                                                    <tr>
                                                        <th>Примечания администратора</th>
                                                        <td>{{ $verification->admin_notes }}</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                    @if($verification->status != 'approved')
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <a href="{{ route('seller.verification.form') }}" class="btn btn-primary">
                                                    <i class="mdi mdi-plus"></i> Подать новый запрос на верификацию
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info">
                                        <h4 class="alert-heading">Нет данных о верификации</h4>
                                        <p>У вас еще нет запросов на верификацию.</p>
                                        <a href="{{ route('seller.verification.form') }}" class="btn btn-primary">
                                            <i class="mdi mdi-plus"></i> Подать запрос на верификацию
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection