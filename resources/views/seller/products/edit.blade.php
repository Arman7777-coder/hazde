@extends('seller.layouts.header-sidebar')
@section('styles')
    <link href="{{asset('admin-src/libs/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            max-width: 500px;
        }
        
        .calendar-header {
            text-align: center;
            font-weight: bold;
            padding: 10px 0;
        }
        
        .calendar-day {
            text-align: center;
            padding: 10px 0;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .calendar-day:hover {
            background-color: #f0f0f0;
        }
        
        .calendar-day.unavailable {
            background-color: #dc3545;
            color: white;
        }
        
        .calendar-day.unavailable:hover {
            background-color: #c82333;
        }
        
        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .calendar-nav button {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .calendar-nav button:hover {
            background: #0056b3;
        }
        
        #selected-dates {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .date-tag {
            display: inline-block;
            background-color: #dc3545;
            color: white;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 12px;
            font-size: 12px;
        }
        
        .date-tag .remove-date {
            margin-left: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('title')
    Редактирование товара
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Редактировать товар</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      enctype="multipart/form-data"
                                      action="{{route('seller.products.update', $product->id)}}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputName" class="form-label">Название *</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Название товара" value="{{ old('name', $product->name) }}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputPrice" class="form-label">Цена *</label>
                                            <input type="number" class="form-control" id="inputPrice" name="price"
                                                   placeholder="0.00" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCategory" class="form-label">Категория *</label>
                                            <select class="form-control" id="inputCategory" name="category_id" required>
                                                <option value="">Выберите категорию</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif data-filters="{{ json_encode($category->filters) }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputPriceType" class="form-label">Тип цены *</label>
                                            <select class="form-control" id="inputPriceType" name="price_type" required>
                                                <option value="fixed" @if(old('price_type', $product->price_type) == 'fixed') selected @endif>Фиксированная цена</option>
                                                <option value="hourly" @if(old('price_type', $product->price_type) == 'hourly') selected @endif>Почасовая ставка</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Dynamic Filters Container -->
                                    <div id="dynamicFilters" class="row">
                                        <!-- Filters will be loaded here dynamically -->
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputDescription" class="form-label">Описание</label>
                                            <textarea class="form-control" id="inputDescription" name="description" 
                                                      rows="4" placeholder="Описание товара">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputDetails" class="form-label">Детали</label>
                                            <textarea class="form-control" id="inputDetails" name="details" 
                                                      rows="4" placeholder="Детали товара">{{ old('details', $product->details) }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputLocation" class="form-label">Местоположение *</label>
                                            <select class="form-control" id="inputLocation" name="location" required>
                                                <option value="">Выберите регион</option>
                                                <option value="Чеченская Республика" @if(old('location', $product->location ?? '') == 'Чеченская Республика') selected @endif>Чеченская Республика</option>
                                                <option value="Дагестан" @if(old('location', $product->location ?? '') == 'Дагестан') selected @endif>Дагестан</option>
                                                <option value="Ингушетия" @if(old('location', $product->location ?? '') == 'Ингушетия') selected @endif>Ингушетия</option>
                                            </select>
                                            <small class="text-muted">Выберите регион из списка</small>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputImages" class="form-label">Изображения товара (Максимум: {{ $maxImages }})</label>
                                            <input type="file" id="inputImages" name="images[]" class="dropify" multiple accept="image/*" />
                                            <small class="text-muted">Вы можете выбрать до {{ $maxImages }} изображений. 
                                            @if(Auth::user()->subscription && Auth::user()->subscription->plan)
                                                Текущий план: {{ Auth::user()->subscription->plan->name }}
                                            @else
                                                Текущий план: Базовый (бесплатный)
                                            @endif
                                            </small>
                                            
                                            @if($product->images->count() > 0)
                                            <div class="row mt-2">
                                                @foreach($product->images as $image)
                                                <div class="col-md-3">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Add PDF document upload for Pro plan users (plan ID 3) -->
                                    @if(Auth::user()->subscription && Auth::user()->subscription->plan && Auth::user()->subscription->plan->id === 3)
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputPdfDocument" class="form-label">PDF документ (необязательно)</label>
                                            <input type="file" id="inputPdfDocument" name="pdf_document" class="form-control" accept="application/pdf" />
                                            @if($product->pdf_document_path)
                                                <small class="text-muted">
                                                    Текущий PDF документ: 
                                                    <a href="{{ asset('storage/' . $product->pdf_document_path) }}" target="_blank">Просмотреть</a>
                                                </small>
                                            @endif
                                            <small class="text-muted">Вы можете загрузить PDF документ с дополнительной информацией о товаре (только для Pro пользователей)</small>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Calendar for unavailable dates -->
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Недоступные даты</label>
                                            <div class="calendar-container">
                                                <div id="calendar"></div>
                                                <div id="selected-dates" class="mt-3">
                                                    <h6>Выбранные даты:</h6>
                                                    <ul id="date-list" class="list-unstyled"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Обновить товар</button>
                                    <a href="{{ route('seller.products.index') }}" class="btn btn-secondary mt-3">Отмена</a>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
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
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('admin-src/js/pages/form-advanced.init.js')}}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Dropify for multiple image upload
            if ($.fn.dropify) {
                $('#inputImages').dropify({
                    messages: {
                        'default': 'Перетащите файлы сюда или нажмите для выбора',
                        'replace': 'Перетащите файлы сюда или нажмите для замены',
                        'remove': 'Удалить',
                        'error': 'Произошла ошибка при загрузке файла'
                    },
                    error: {
                        'fileSize': 'Файл слишком большой (максимум 2МБ).',
                        'minWidth': 'Ширина изображения слишком мала (мин. 100px).',
                        'maxWidth': 'Ширина изображения слишком велика (макс. 5000px).',
                        'minHeight': 'Высота изображения слишком мала (мин. 100px).',
                        'maxHeight': 'Высота изображения слишком велика (макс. 5000px).',
                        'imageFormat': 'Недопустимый формат изображения (только jpg, png, gif).',
                        'fileNumber': 'Количество выбранных файлов превышает лимит (макс. {{ $maxImages }}).'
                    }
                });
            }
            
            // Add form submit handler to ensure dates are saved
            const form = document.getElementById('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Update the hidden field with current selected dates
                    document.getElementById('unavailable_dates').value = JSON.stringify(selectedDates);
                });
            }
            
            // Calendar functionality
            let selectedDates = [];
            let currentMonth = new Date().getMonth();
            let currentYear = new Date().getFullYear();
            
            // Load existing unavailable dates
            loadUnavailableDates();
            
            // Render calendar
            renderCalendar(currentMonth, currentYear);
            
            function loadUnavailableDates() {
                fetch(`/seller/products/{{ $product->id }}/unavailable-dates`)
                    .then(response => response.json())
                    .then(dates => {
                        selectedDates = dates;
                        // Update hidden input with initial dates
                        updateHiddenInputs();
                        updateSelectedDatesDisplay();
                        renderCalendar(currentMonth, currentYear);
                    })
                    .catch(error => {
                        console.error('Error loading unavailable dates:', error);
                    });
            }
            
            function renderCalendar(month, year) {
                const calendarEl = document.getElementById('calendar');
                calendarEl.innerHTML = '';
                
                // Calendar navigation
                const nav = document.createElement('div');
                nav.className = 'calendar-nav';
                
                const prevButton = document.createElement('button');
                prevButton.innerHTML = '&larr;';
                prevButton.addEventListener('click', () => {
                    currentMonth--;
                    if (currentMonth < 0) {
                        currentMonth = 11;
                        currentYear--;
                    }
                    renderCalendar(currentMonth, currentYear);
                });
                
                const monthYear = document.createElement('span');
                monthYear.textContent = new Date(year, month).toLocaleString('ru-RU', { month: 'long', year: 'numeric' });
                monthYear.style.textTransform = 'capitalize';
                
                const nextButton = document.createElement('button');
                nextButton.innerHTML = '&rarr;';
                nextButton.addEventListener('click', () => {
                    currentMonth++;
                    if (currentMonth > 11) {
                        currentMonth = 0;
                        currentYear++;
                    }
                    renderCalendar(currentMonth, currentYear);
                });
                
                nav.appendChild(prevButton);
                nav.appendChild(monthYear);
                nav.appendChild(nextButton);
                calendarEl.appendChild(nav);
                
                // Calendar header
                const days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
                const header = document.createElement('div');
                header.className = 'calendar';
                
                days.forEach(day => {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'calendar-header';
                    dayEl.textContent = day;
                    header.appendChild(dayEl);
                });
                
                calendarEl.appendChild(header);
                
                // Calendar days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                
                const calendar = document.createElement('div');
                calendar.className = 'calendar';
                
                // Empty cells for days before the first day of the month
                for (let i = 1; i < (firstDay || 7); i++) {
                    const emptyCell = document.createElement('div');
                    calendar.appendChild(emptyCell);
                }
                
                // Days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'calendar-day';
                    dayEl.textContent = day;
                    
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    
                    // Highlight today
                    const today = new Date();
                    if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
                        dayEl.style.fontWeight = 'bold';
                        dayEl.style.backgroundColor = '#e9ecef';
                    }
                    
                    // Mark unavailable dates
                    if (selectedDates.includes(dateStr)) {
                        dayEl.classList.add('unavailable');
                    }
                    
                    dayEl.addEventListener('click', () => {
                        toggleDate(dateStr);
                        dayEl.classList.toggle('unavailable');
                    });
                    
                    calendar.appendChild(dayEl);
                }
                
                calendarEl.appendChild(calendar);
            }
            
            function toggleDate(dateStr) {
                const index = selectedDates.indexOf(dateStr);
                if (index === -1) {
                    selectedDates.push(dateStr);
                } else {
                    selectedDates.splice(index, 1);
                }
                updateHiddenInputs();
                updateSelectedDatesDisplay();
                saveUnavailableDates();
            }
            
            function updateHiddenInputs() {
                // Remove any existing hidden inputs for unavailable dates
                const existingInputs = document.querySelectorAll('input[name="unavailable_dates[]"]');
                existingInputs.forEach(input => input.remove());
                
                // Create hidden inputs for each selected date
                if (selectedDates.length > 0) {
                    selectedDates.forEach(date => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'unavailable_dates[]';
                        hiddenInput.value = date;
                        form.appendChild(hiddenInput);
                    });
                }
            }
            
            function updateSelectedDatesDisplay() {
                const dateList = document.getElementById('date-list');
                dateList.innerHTML = '';
                
                if (selectedDates.length === 0) {
                    dateList.innerHTML = '<li>Нет выбранных дат</li>';
                    return;
                }
                
                selectedDates.forEach(date => {
                    const li = document.createElement('li');
                    li.className = 'd-inline-block mr-2 mb-2';
                    
                    const dateTag = document.createElement('span');
                    dateTag.className = 'date-tag';
                    dateTag.innerHTML = `${formatDate(date)} <span class="remove-date" data-date="${date}">&times;</span>`;
                    
                    li.appendChild(dateTag);
                    dateList.appendChild(li);
                });
                
                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-date').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const date = button.getAttribute('data-date');
                        toggleDate(date);
                        renderCalendar(currentMonth, currentYear);
                    });
                });
            }
            
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('ru-RU');
            }
            
            function saveUnavailableDates() {
                fetch(`/seller/products/{{ $product->id }}/unavailable-dates`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        dates: selectedDates
                    })
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Unavailable dates saved successfully');
                    } else {
                        console.error('Failed to save unavailable dates');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            
            const categorySelect = document.getElementById('inputCategory');
            const dynamicFiltersContainer = document.getElementById('dynamicFilters');
            
            // Function to load filters
            function loadFilters() {
                // Check if categorySelect exists
                if (!categorySelect) return;
                
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const filters = JSON.parse(selectedOption.getAttribute('data-filters') || '[]');
                
                // Clear existing filters
                dynamicFiltersContainer.innerHTML = '';
                
                // Get existing filter values if editing
                const existingValues = @if(isset($product)) @json($product->filterValues->pluck('filter_option_id', 'filter_id')->toArray()) @else {} @endif;
                
                // Add new filters
                if (filters.length > 0) {
                    const filterHeader = document.createElement('div');
                    filterHeader.className = 'col-12 mb-3';
                    filterHeader.innerHTML = '<h5 class="header-title">Фильтры категории</h5>';
                    dynamicFiltersContainer.appendChild(filterHeader);
                    
                    filters.forEach(function(filter) {
                        const filterRow = document.createElement('div');
                        filterRow.className = 'col-md-6 mb-3';
                        
                        let inputHtml = '';
                        const existingValue = existingValues[filter.id] || '';
                        
                        if (filter.options && filter.options.length > 0) {
                            // Select dropdown for filters with options
                            inputHtml = `
                                <label for="filter_${filter.id}" class="form-label">${filter.title || filter.name}</label>
                                <select class="form-control" id="filter_${filter.id}" name="filters[${filter.id}]">
                                    <option value="">Выберите ${filter.title || filter.name}</option>
                            `;
                            
                            filter.options.forEach(function(option) {
                                const selected = option.id == existingValue ? 'selected' : '';
                                inputHtml += `<option value="${option.id}" ${selected}>${option.name}</option>`;
                            });
                            
                            inputHtml += '</select>';
                        } else {
                            // Text input for filters without options
                            inputHtml = `
                                <label for="filter_${filter.id}" class="form-label">${filter.title || filter.name}</label>
                                <input type="text" class="form-control" id="filter_${filter.id}" name="filters[${filter.id}]" 
                                       placeholder="${filter.title || filter.name}" value="${existingValue}">
                            `;
                        }
                        
                        filterRow.innerHTML = inputHtml;
                        dynamicFiltersContainer.appendChild(filterRow);
                    });
                }
            }
            
            // Load filters when category changes
            if (categorySelect) {
                categorySelect.addEventListener('change', loadFilters);
                
                // Load filters on page load
                loadFilters();
            }
        });
    </script>
@endsection