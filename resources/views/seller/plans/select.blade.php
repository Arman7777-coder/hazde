@extends('seller.layouts.header-sidebar')

@section('title', 'Выбор тарифного плана')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    Выберите тарифный план
                </div>

                <div class="mt-6 text-gray-500">
                    Пожалуйста, выберите один из доступных тарифных планов для размещения ваших товаров.
                </div>
            </div>

            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                @foreach($plans as $plan)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">{{ ucfirst($plan->name) }}</h3>
                            @if($plan->price == 0)
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Бесплатно</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ number_format($plan->price, 0, ',', ' ') }} руб./мес</span>
                            @endif
                        </div>

                        <p class="mt-4 text-gray-600">
                            {{ $plan->description }}
                        </p>

                        <ul class="mt-6 space-y-3">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="ml-2 text-gray-600">
                                    @if($plan->max_products === null)
                                        Неограниченное количество товаров
                                    @else
                                        До {{ $plan->max_products }} товаров
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="ml-2 text-gray-600">
                                    До {{ $plan->max_images_per_product }} изображений на товар
                                </span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="ml-2 text-gray-600">
                                    @if($plan->can_set_price)
                                        Возможность установки цены
                                    @else
                                        Фиксированная цена
                                    @endif
                                </span>
                            </li>
                        </ul>

                        <div class="mt-8">
                            <button 
                                onclick="selectPlan({{ $plan->id }})" 
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            >
                                Выбрать тариф
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                            Оплата тарифа
                        </h3>
                        <div class="mt-2" id="modalContent">
                            <p class="text-sm text-gray-500">
                                Вы будете перенаправлены на страницу оплаты выбранного тарифа.
                            </p>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500" id="planDetails"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="paymentForm" method="POST">
                    @csrf
                    <input type="hidden" name="plan_id" id="planIdInput">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Перейти к оплате
                    </button>
                </form>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Отмена
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPlan(planId) {
        // 获取套餐详情
        fetch(`/api/plans/${planId}`)
            .then(response => response.json())
            .then(plan => {
                // 填充模态框内容
                document.getElementById('planDetails').innerText = `${plan.name}: ${plan.description}`;
                document.getElementById('planIdInput').value = plan.id;
                document.getElementById('paymentForm').action = `/seller/plans/${plan.id}/subscribe`;
                
                // 显示模态框
                document.getElementById('paymentModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при получении информации о тарифе.');
            });
    }

    function closeModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // 点击模态框外部关闭
    window.onclick = function(event) {
        const modal = document.getElementById('paymentModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endsection