@extends('seller.layouts.header-sidebar')
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
    Создание товара
@endsection

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Создать товар</h4>
                                <p class="text-muted font-13"></p>

                                <form class="needs-validation" method="post" id="form" novalidate
                                      enctype="multipart/form-data"
                                      action="{{route('seller.products.store')}}">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputName" class="form-label">Название *</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Название товара" value="{{ old('name') }}" required>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputPrice" class="form-label">Цена *</label>
                                            <input type="number" class="form-control" id="inputPrice" name="price"
                                                   placeholder="0.00" value="{{ old('price') }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCategory" class="form-label">Категория *</label>
                                            <select class="form-control" id="inputCategory" name="category_id" required>
                                                <option value="">Выберите категорию</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif data-filters="{{ json_encode($category->filters) }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="inputPriceType" class="form-label">Тип цены *</label>
                                            <select class="form-control" id="inputPriceType" name="price_type" required>
                                                <option value="fixed" @if(old('price_type') == 'fixed') selected @endif>Фиксированная цена</option>
                                                <option value="hourly" @if(old('price_type') == 'hourly') selected @endif>Почасовая ставка</option>
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
                                                      rows="4" placeholder="Описание товара">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputDetails" class="form-label">Детали</label>
                                            <textarea class="form-control" id="inputDetails" name="details" 
                                                      rows="4" placeholder="Детали товара">{{ old('details') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="inputLocation" class="form-label">Местоположение *</label>
                                            <input type="text" class="form-control" id="inputLocation" name="location"
                                                   placeholder="Местоположение товара" value="{{ old('location') }}" required>
                                            <small class="text-muted">Укажите местоположение товара (город, район и т.д.)</small>
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
                                            
                                            <!-- Image preview container -->
                                            <div id="imagePreview" class="row mt-3"></div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">Создать товар</button>
                                    <a href="{{ route('seller.products.index') }}" class="btn btn-secondary mt-3">Отмена</a>
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
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/dropify/js/dropify.min.js')}}"></script>

    <script src="{{asset('admin-src/js/pages/form-advanced.init.js')}}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store selected files
            let selectedFiles = [];
            
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
            
            // Add image preview functionality
            const inputImages = document.getElementById('inputImages');
            const imagePreview = document.getElementById('imagePreview');
            
            if (inputImages) {
                inputImages.addEventListener('change', function(e) {
                    // Add new files to the selected files array
                    if (this.files) {
                        for (let i = 0; i < this.files.length; i++) {
                            const file = this.files[i];
                            // Check if file is already selected
                            const alreadySelected = selectedFiles.some(selectedFile => 
                                selectedFile.name === file.name && 
                                selectedFile.size === file.size && 
                                selectedFile.lastModified === file.lastModified
                            );
                            
                            if (!alreadySelected && file.type.match('image.*')) {
                                selectedFiles.push(file);
                            }
                        }
                    }
                    
                    // Limit to maxImages
                    if (selectedFiles.length > {{ $maxImages }}) {
                        selectedFiles = selectedFiles.slice(0, {{ $maxImages }});
                    }
                    
                    // Update the preview
                    updateImagePreview();
                    
                    // Update the actual input with the selected files
                    updateFileInput();
                });
            }
            
            function updateImagePreview() {
                imagePreview.innerHTML = '';
                
                selectedFiles.forEach((file, index) => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-3 mb-2 position-relative';
                    
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'img-fluid rounded border';
                    img.style.maxHeight = '150px';
                    
                    const fileName = document.createElement('div');
                    fileName.className = 'text-center small mt-1';
                    fileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
                    
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    removeButton.innerHTML = '&times;';
                    removeButton.onclick = function() {
                        removeFile(index);
                    };
                    
                    colDiv.appendChild(img);
                    colDiv.appendChild(fileName);
                    colDiv.appendChild(removeButton);
                    imagePreview.appendChild(colDiv);
                });
            }
            
            function removeFile(index) {
                selectedFiles.splice(index, 1);
                updateImagePreview();
                updateFileInput();
            }
            
            function updateFileInput() {
                // Create a new DataTransfer to update the input files
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                inputImages.files = dataTransfer.files;
            }
            
            const categorySelect = document.getElementById('inputCategory');
            const dynamicFiltersContainer = document.getElementById('dynamicFilters');
            
            // Load filters when category changes
            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const filters = JSON.parse(selectedOption.getAttribute('data-filters') || '[]');
                
                // Clear existing filters
                dynamicFiltersContainer.innerHTML = '';
                
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
                        
                        if (filter.options && filter.options.length > 0) {
                            // Select dropdown for filters with options
                            inputHtml = `
                                <label for="filter_${filter.id}" class="form-label">${filter.title || filter.name}</label>
                                <select class="form-control" id="filter_${filter.id}" name="filters[${filter.id}]">
                                    <option value="">Выберите ${filter.title || filter.name}</option>
                            `;
                            
                            filter.options.forEach(function(option) {
                                inputHtml += `<option value="${option.id}">${option.name}</option>`;
                            });
                            
                            inputHtml += '</select>';
                        } else {
                            // Text input for filters without options
                            inputHtml = `
                                <label for="filter_${filter.id}" class="form-label">${filter.title || filter.name}</label>
                                <input type="text" class="form-control" id="filter_${filter.id}" name="filters[${filter.id}]" 
                                       placeholder="${filter.title || filter.name}">
                            `;
                        }
                        
                        filterRow.innerHTML = inputHtml;
                        dynamicFiltersContainer.appendChild(filterRow);
                    });
                }
            });
            
            // Trigger change event on page load if a category is already selected
            if (categorySelect.value) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection