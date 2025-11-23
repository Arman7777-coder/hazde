@extends('admin.layouts.header-sidebar')

@section('title', 'Просмотр запроса на верификацию')

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
                                        <h4 class="header-title">Просмотр запроса на верификацию</h4>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="{{ route('admin.seller-verifications.index') }}" class="btn btn-primary">
                                            <i class="mdi mdi-arrow-left"></i> Назад к списку
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Информация о запросе</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Продавец</th>
                                                <td>{{ $verification->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $verification->user->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Тип документа</th>
                                                <td>{{ $verification->document_type ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Имя</th>
                                                <td>{{ $verification->first_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Фамилия</th>
                                                <td>{{ $verification->last_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Номер документа</th>
                                                <td>{{ $verification->id_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Дата подачи</th>
                                                <td>{{ $verification->created_at ? $verification->created_at->format('d.m.Y H:i') : 'N/A' }}</td>
                                            </tr>
                                            @if($verification->verified_at)
                                            <tr>
                                                <th>Дата верификации</th>
                                                <td>{{ $verification->verified_at->format('d.m.Y H:i') }}</td>
                                            </tr>
                                            @endif
                                            @if($verification->admin_notes)
                                            <tr>
                                                <th>Примечания администратора</th>
                                                <td>{{ $verification->admin_notes }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <h5>Документы</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h6>Лицевая сторона документа</h6>
                                                        @if($verification->document_front_path)
                                                            <img src="{{ asset('storage/' . $verification->document_front_path) }}" class="img-fluid" alt="Лицевая сторона документа">
                                                        @else
                                                            <p class="text-muted">Изображение не загружено</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h6>Оборотная сторона документа</h6>
                                                        @if($verification->document_back_path)
                                                            <img src="{{ asset('storage/' . $verification->document_back_path) }}" class="img-fluid" alt="Оборотная сторона документа">
                                                        @else
                                                            <p class="text-muted">Изображение не загружено</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <h6>Селфи с документом</h6>
                                                        @if($verification->selfie_with_document_path)
                                                            <img src="{{ asset('storage/' . $verification->selfie_with_document_path) }}" class="img-fluid" alt="Селфи с документом">
                                                        @else
                                                            <p class="text-muted">Изображение не загружено</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('admin.seller-verifications.approve', $verification->id) }}" class="d-inline">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="admin_notes" class="form-label">Примечания (необязательно)</label>
                                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $verification->admin_notes) }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success">
                                                <i class="mdi mdi-check"></i> Одобрить
                                            </button>
                                            <a href="{{ route('admin.seller-verifications.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left"></i> Назад
                                            </a>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.seller-verifications.reject', $verification->id) }}" class="d-inline mt-3">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="reject_notes" class="form-label">Причина отказа (обязательно)</label>
                                                <textarea class="form-control" id="reject_notes" name="admin_notes" rows="3" required>{{ old('admin_notes', $verification->admin_notes) }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="mdi mdi-close"></i> Отклонить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection