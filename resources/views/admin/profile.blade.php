@extends('admin.layouts.header-sidebar')
@section('styles')
    <link href="{{asset('admin-src/libs/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>

@endsection
@section('title')
    Обновление профиля
@endsection
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Обновить</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      enctype="multipart/form-data"
                                      action="{{route('profile.update', $user->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Имя</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{$user->name}}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="inputEmail4" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="inputEmail4"
                                                   name="email" value="{{$user->email}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Новый пароль</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" id="password" class="form-control"
                                                       placeholder="Введите новый пароль" name="password">
                                                <div class="input-group-text show-password" data-password="true">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password-confirm" class="form-label">Подтвердите новый
                                                пароль</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" id="password-confirm" class="form-control"
                                                       placeholder="Подтвердите новый пароль" name="password_confirmation">
                                                <div class="input-group-text show-password" data-password="true">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputAddress" class="form-label">Адрес</label>
                                            <input type="text" class="form-control" id="inputAddress"
                                                   placeholder="ул. Примерная, д. 1234" value="{{$user->address}}" name="address">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="inputAddress2" class="form-label">Адрес 2</label>
                                            <input type="text" class="form-control" id="inputAddress2"
                                                   placeholder="Квартира, офис, этаж" value="{{$user->address2}}"
                                                   name="address2">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="example-date" class="form-label">Дата рождения</label>
                                            <input class="form-control" id="example-date" type="date"
                                                   @if($user->birth_date) value="{{\Carbon\Carbon::parse($user->birth_date)->format('Y-m-d')}}"
                                                   @endif name="birth_date">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="inputCity" class="form-label">Город</label>
                                            <input type="text" class="form-control" value="{{$user->city}}"
                                                   id="inputCity" name="city">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="inputState" class="form-label">Область</label>
                                            <input type="text" class="form-control" value="{{$user->state}}"
                                                   id="inputState" name="state">
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="inputZip" class="form-label">Индекс</label>
                                            <input type="text" class="form-control" value="{{$user->zip_code}}"
                                                   id="inputZip" name="zip_code">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Телефон</label>
                                            <input type="text" class="form-control" id="phone" value="{{$user->phone_number}}"
                                                   name="phone_number">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="image" class="form-label">Аватар</label>
                                            <input type="file" id="image" name="avatar"
                                                   data-plugins="dropify" data-default-file="{{asset($user->avatar)}}"/>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Обновить профиль</button>
                                </form>

                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('admin-src/libs/selectize/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('admin-src/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('admin-src/js/pages/form-advanced.init.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('[data-plugins="dropify"]').dropify({
                messages: {
                    default: "Перетащите файл сюда или нажмите",
                    replace: "Перетащите или нажмите для замены",
                    remove: "Удалить",
                    error: "Упс, что-то пошло не так."
                }, error: {fileSize: "Размер файла слишком большой (макс. 1М)."}
            });
        })
    </script>
@endsection