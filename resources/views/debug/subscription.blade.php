@extends('seller.layouts.header-sidebar')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Subscription Debug Info</h4>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>User Info</h5>
                                    <pre>{{ print_r(Auth::user()->toArray(), true) }}</pre>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Subscription Info</h5>
                                    @if(Auth::user()->subscription)
                                        <pre>{{ print_r(Auth::user()->subscription->toArray(), true) }}</pre>
                                        
                                        <h5>Plan Info</h5>
                                        @if(Auth::user()->subscription->plan)
                                            <pre>{{ print_r(Auth::user()->subscription->plan->toArray(), true) }}</pre>
                                        @else
                                            <p>No plan found</p>
                                        @endif
                                    @else
                                        <p>No subscription found</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>All Plans</h5>
                                    @foreach(App\Models\SellerPlan::all() as $plan)
                                        <p>{{ $plan->name }}: {{ $plan->max_images_per_product }} images</p>
                                    @endforeach
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