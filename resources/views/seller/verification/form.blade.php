@extends('seller.layouts.header-sidebar')

@section('title', 'Верификация продавца')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Верификация продавца</h4>
                        </div>
                    </div>
                </div>

                @if($existingVerification)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">Уведомление о статусе верификации</h4>
                                <p>У вас уже есть запрос на верификацию со статусом: <strong>{{ ucfirst($existingVerification->status) }}</strong></p>
                                <a href="{{ route('seller.verification.status') }}" class="btn btn-primary">
                                    <i class="mdi mdi-eye"></i> Посмотреть статус
                                </a>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Форма верификации</h4>
                                    <p class="text-muted font-14">
                                        Пожалуйста, заполните форму ниже, чтобы подтвердить свою личность и получить статус верифицированного продавца.
                                    </p>

                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('seller.verification.submit') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="document_type" class="form-label">Тип документа</label>
                                                    <select class="form-select" id="document_type" name="document_type" required>
                                                        <option value="">Выберите тип документа</option>
                                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Паспорт</option>
                                                        <option value="driver_license" {{ old('document_type') == 'driver_license' ? 'selected' : '' }}>Водительское удостоверение</option>
                                                        <option value="id_card" {{ old('document_type') == 'id_card' ? 'selected' : '' }}>Удостоверение личности</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">Имя</label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">Фамилия</label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="id_number" class="form-label">Номер документа</label>
                                                    <input type="text" class="form-control" id="id_number" name="id_number" value="{{ old('id_number') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="document_front" class="form-label">Фото лицевой стороны документа</label>
                                                    <input type="file" class="form-control" id="document_front" name="document_front" accept="image/*" required>
                                                    <div class="form-text">Загрузите четкое фото лицевой стороны вашего документа</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="document_back" class="form-label">Фото оборотной стороны документа</label>
                                                    <input type="file" class="form-control" id="document_back" name="document_back" accept="image/*">
                                                    <div class="form-text">Загрузите четкое фото оборотной стороны вашего документа (если применимо)</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="selfie_with_document" class="form-label">Селфи с документом</label>
                                                    <input type="file" class="form-control" id="selfie_with_document" name="selfie_with_document" accept="image/*">
                                                    <div class="form-text">Загрузите фото себя с документом, где хорошо видны ваше лицо и документ</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-send"></i> Отправить на верификацию
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection