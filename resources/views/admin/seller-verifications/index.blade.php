@extends('admin.layouts.header-sidebar')

@section('title', 'Запросы на верификацию продавцов')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h4 class="header-title">Запросы на верификацию продавцов</h4>
                                    </div>
                                </div>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if($verifications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Продавец</th>
                                                    <th>Тип документа</th>
                                                    <th>Имя</th>
                                                    <th>Фамилия</th>
                                                    <th>Номер документа</th>
                                                    <th>Дата подачи</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($verifications as $verification)
                                                    <tr>
                                                        <td>
                                                            {{ $verification->user->name ?? 'N/A' }}
                                                            <br>
                                                            <small>{{ $verification->user->email ?? 'N/A' }}</small>
                                                        </td>
                                                        <td>{{ $verification->document_type }}</td>
                                                        <td>{{ $verification->first_name }}</td>
                                                        <td>{{ $verification->last_name }}</td>
                                                        <td>{{ $verification->id_number }}</td>
                                                        <td>{{ $verification->created_at ? $verification->created_at->format('d.m.Y H:i') : 'N/A' }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.seller-verifications.show', $verification->id) }}" class="btn btn-info btn-sm">
                                                                <i class="mdi mdi-eye"></i> Просмотр
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-4">
                                        {{ $verifications->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-muted">Нет ожидающих запросов на верификацию.</p>
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