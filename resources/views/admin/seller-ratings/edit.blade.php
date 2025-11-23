@extends('admin.layouts.header-sidebar')

@section('title', 'Edit Seller Rating')

@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-3">Edit Seller Rating</h4>
                                
                                <!-- Debug information -->
                                <p>Sellers count: {{ $sellers->count() }}</p>
                                
                                <form action="{{ route('admin.seller-ratings.update', $rating->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="seller_id" class="form-label">Seller</label>
                                                <select class="form-select" id="seller_id" name="seller_id" required>
                                                    <option value="">Select Seller ({{ $sellers->count() }} available)</option>
                                                    @foreach($sellers as $seller)
                                                        <option value="{{ $seller->id }}" {{ (old('seller_id', $rating->seller_id) == $seller->id) ? 'selected' : '' }}>
                                                            {{ $seller->name }} ({{ $seller->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="rating" class="form-label">Rating</label>
                                                <select class="form-select" id="rating" name="rating" required>
                                                    <option value="">Select Rating</option>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}" {{ (old('rating', $rating->rating) == $i) ? 'selected' : '' }}>
                                                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Add any notes about this rating...">{{ old('notes', $rating->notes) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.seller-ratings.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-danger">Update Rating</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection