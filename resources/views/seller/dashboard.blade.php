@extends('seller.layouts.header-sidebar')

@section('title')
    Панель продавца
@endsection

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Продавец</a></li>
                                    <li class="breadcrumb-item active">Панель управления</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Панель управления</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-4">Всего товаров</h4>

                                <div class="widget-chart-1">
                                    <div class="widget-chart-box-1 float-start" dir="ltr">
                                        <input data-plugin="knob" data-width="70" data-height="70"
                                               data-fgColor="#f05050 "
                                               data-bgColor="#F9B9B9" value="{{ $productsCount }}"
                                               data-skin="tron" data-angleOffset="180" data-readOnly=true
                                               data-thickness=".15"/>
                                    </div>

                                    <div class="widget-detail-1 text-end">
                                        <h2 class="fw-normal pt-2 mb-1"> {{ $productsCount }} </h2>
                                        <p class="text-muted mb-1">Все товары</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">Одобренные товары</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-end">
                                        <span class="badge bg-success rounded-pill float-start mt-3">{{ $approvedProductsPercentage }}% <i
                                                class="mdi mdi-trending-up"></i> </span>
                                        <h2 class="fw-normal mb-1"> {{ $approvedProductsCount }} </h2>
                                        <p class="text-muted mb-3">Одобренные товары</p>
                                    </div>
                                    <div class="progress progress-bar-alt-success progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             aria-valuenow="{{ $approvedProductsPercentage }}" aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{ $approvedProductsPercentage }}%;">
                                            <span class="visually-hidden">{{ $approvedProductsPercentage }}% Завершено</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-4">Товары на рассмотрении</h4>

                                <div class="widget-chart-1">
                                    <div class="widget-chart-box-1 float-start" dir="ltr">
                                        <input data-plugin="knob" data-width="70" data-height="70"
                                               data-fgColor="#ffbd4a"
                                               data-bgColor="#FFE6BA" value="{{ $pendingProductsPercentage }}"
                                               data-skin="tron" data-angleOffset="180" data-readOnly=true
                                               data-thickness=".15"/>
                                    </div>
                                    <div class="widget-detail-1 text-end">
                                        <h2 class="fw-normal pt-2 mb-1"> {{ $pendingProductsCount }} </h2>
                                        <p class="text-muted mb-1">Ожидает одобрения</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">Статус подписки</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-end">
                                        <span class="badge bg-pink rounded-pill float-start mt-3">@if($subscriptionActive) Активна @else Неактивна @endif</span>
                                        <h2 class="fw-normal mb-1"> @if($subscriptionActive) Активна @else Неактивна @endif </h2>
                                        <p class="text-muted mb-3">Статус плана</p>
                                    </div>
                                    <div class="progress progress-bar-alt-pink progress-sm">
                                        <div class="progress-bar bg-pink" role="progressbar"
                                             aria-valuenow="@if($subscriptionActive) 100 @else 0 @endif" aria-valuemin="0" aria-valuemax="100"
                                             style="width: @if($subscriptionActive) 100% @else 0% @endif;">
                                            <span class="visually-hidden">@if($subscriptionActive) 100% @else 0% @endif Завершено</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">Верификация</h4>

                                <div class="widget-box-2">
                                    <div class="widget-detail-2 text-end">
                                        @php

                                            $verificationStatus = auth()->user()->is_verified_seller ? 'Подтверждён' : 'Не подтверждён';
                                            $verificationBadgeClass = auth()->user()->is_verified_seller ? 'bg-success' : 'bg-warning';
                                        @endphp
                                        <span class="badge {{ $verificationBadgeClass }} rounded-pill float-start mt-3">{{ $verificationStatus }}</span>
                                        <h2 class="fw-normal mb-1">
                                            @if(auth()->user()->is_verified_seller)
                                                Подтверждён
                                            @else
                                                Не подтверждён
                                            @endif
                                        </h2>
                                        <p class="text-muted mb-3">Статус аккаунта</p>
                                    </div>
                                    <div class="progress progress-bar-alt-pink progress-sm">
                                        <div class="progress-bar {{ auth()->user()->is_verified_seller ? 'bg-success' : 'bg-warning' }}"
                                             role="progressbar"
                                             aria-valuenow="@if(auth()->user()->is_verified_seller) 100 @else 0 @endif"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width: @if(auth()->user()->is_verified_seller) 100% @else 0% @endif;">
                                            <span class="visually-hidden">@if(auth()->user()->is_verified_seller) Верифицирован @else Требуется верификация @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0">Статус товаров</h4>

                                <div class="widget-chart text-center">
                                    <div id="morris-donut-example" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                                    <ul class="list-inline chart-detail-list mb-0">
                                        <li class="list-inline-item">
                                            <h5 style="color: #ff8acc;"><i class="fa fa-circle me-1"></i>Одобрено</h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 style="color: #5b69bc;"><i class="fa fa-circle me-1"></i>На рассмотрении</h5>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 style="color: #35b8e0;"><i class="fa fa-circle me-1"></i>Отклонено</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>
                                <h4 class="header-title mt-0">Недавняя активность</h4>
                                <div id="morris-bar-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>
                                <h4 class="header-title mt-0">Лучшие товары</h4>
                                <div id="morris-line-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Другое действие</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Что-то еще</a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">Отдельная ссылка</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">Недавние товары</h4>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название товара</th>
                                            <th>Категория</th>
                                            <th>Цена</th>
                                            <th>Статус</th>
                                            <th>Создан</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recentProducts as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? 'Н/Д' }}</td>
                                                <td>{{ $product->price ?? 'Не установлена' }}</td>
                                                <td>
                                                    @if($product->status == 'pending')
                                                        <span class="badge bg-warning">На рассмотрении</span>
                                                    @elseif($product->status == 'approved')
                                                        <span class="badge bg-success">Одобрен</span>
                                                    @elseif($product->status == 'rejected')
                                                        <span class="badge bg-danger">Отклонен</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->

        </div> <!-- content -->
    </div>
@endsection

@section('scripts')
    <!--Morris Chart-->
    <script src="{{asset('admin-src/libs/morris.js06/morris.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/raphael/raphael.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            // Donut chart
            if ($('#morris-donut-example').length) {
                Morris.Donut({
                    element: 'morris-donut-example',
                    data: [
                        {label: "Одобрено", value: {{ $approvedProductsCount }}},
                        {label: "На рассмотрении", value: {{ $pendingProductsCount }}},
                        {label: "Отклонено", value: {{ $rejectedProductsCount }}}
                    ],
                    colors: ['#ff8acc', '#5b69bc', '#35b8e0'],
                    resize: true
                });
            }

            // Bar chart
            if ($('#morris-bar-example').length) {
                Morris.Bar({
                    element: 'morris-bar-example',
                    data: [
                        { y: 'Товар 1', a: 100, b: 90 },
                        { y: 'Товар 2', a: 75, b: 65 },
                        { y: 'Товар 3', a: 50, b: 40 },
                        { y: 'Товар 4', a: 75, b: 65 },
                        { y: 'Товар 5', a: 50, b: 40 },
                        { y: 'Товар 6', a: 75, b: 65 },
                        { y: 'Товар 7', a: 100, b: 90 }
                    ],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Просмотры', 'Лайки'],
                    barColors: ['#5b69bc', '#35b8e0'],
                    gridLineColor: '#eef0f2',
                    resize: true
                });
            }

            // Line chart
            if ($('#morris-line-example').length) {
                Morris.Line({
                    element: 'morris-line-example',
                    data: [
                        { y: '2017-01', a: 25, b: 15 },
                        { y: '2017-02', a: 40, b: 30 },
                        { y: '2017-03', a: 30, b: 20 },
                        { y: '2017-04', a: 35, b: 25 },
                        { y: '2017-05', a: 50, b: 40 },
                        { y: '2017-06', a: 40, b: 30 },
                        { y: '2017-07', a: 55, b: 45 }
                    ],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Товары', 'Просмотры'],
                    lineColors: ['#ff8acc', '#5b69bc'],
                    gridLineColor: '#eef0f2',
                    resize: true
                });
            }
        });
    </script>
@endsection
