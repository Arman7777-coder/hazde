@extends('seller.layouts.header-sidebar')

@section('title', 'Выбор тарифного плана')

@section('styles')
    <link href="{{asset('admin-src/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-3">Выбор тарифного плана</h4>
                            
                            <p class="text-muted font-13">
                                Пожалуйста, выберите один из доступных тарифных планов для размещения ваших товаров.
                            </p>

                            <div class="row">
                                @foreach($plans as $plan)
                                <div class="col-lg-4">
                                    <div class="card border border-primary">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h4 class="mt-0 header-title">{{ ucfirst($plan->name) }}</h4>
                                                
                                                    <h2 class="mb-2 mt-0">{{ number_format($plan->price, 0, ',', ' ') }} <small class="text-muted">руб./мес</small></h2>
                                                
                                                <p class="text-muted">{{ $plan->description }}</p>
                                            </div>
                                            
                                            <ul class="list-unstyled plan-features mb-0">
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-bold text-success me-2"></i>
                                                    @if($plan->max_products === null)
                                                        Неограниченное количество товаров
                                                    @else
                                                        До {{ $plan->max_products }} товаров
                                                    @endif
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-bold text-success me-2"></i>
                                                    До {{ $plan->max_images_per_product }} изображений на товар
                                                </li>
                                                <li class="mb-2">
                                                    <i class="mdi mdi-check-bold text-success me-2"></i>
                                                    @if($plan->can_set_price)
                                                        Возможность установки цены
                                                    @else
                                                        Фиксированная цена
                                                    @endif
                                                </li>
                                            </ul>
                                            
                                            <div class="text-center mt-3">
                                                <button 
                                                    onclick="selectPlan({{ $plan->id }})" 
                                                    class="btn btn-primary waves-effect waves-light w-100"
                                                >
                                                    Выбрать тариф
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="paymentModalLabel">Оплата тарифа</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы будете перенаправлены на страницу оплаты выбранного тарифа.</p>
                <div class="mt-3">
                    <p id="planDetails"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form id="paymentForm" method="POST">
                    @csrf
                    <input type="hidden" name="plan_id" id="planIdInput">
                    <button type="submit" class="btn btn-primary">Перейти к оплате</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    
    <script>
        function selectPlan(planId) {
            // 获取套餐详情
            fetch(`/api/plans/${planId}`)
                .then(response => response.json())
                .then(plan => {
                    // 填充模态框内容
                    document.getElementById('planDetails').innerText = `${plan.name}: ${plan.description}`;
                    document.getElementById('planIdInput').value = plan.id;
                    document.getElementById('paymentForm').action = `/seller/payment/pay?subscription=${plan.id}`;
                    
                    // 显示模态框
                    var myModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    myModal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Ошибка!',
                        'Произошла ошибка при получении информации о тарифе.',
                        'error'
                    );
                });
        }
    </script>
@endsection