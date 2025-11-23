@extends('admin.layouts.header-sidebar')

@section('styles')
    <link href="{{asset('admin-src/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('admin-src/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title', 'Seller Ratings')

@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <a href="{{ route('admin.seller-ratings.create') }}" class="btn btn-danger mb-2">
                                            <i class="mdi mdi-plus-circle me-2"></i> Add Rating
                                        </a>
                                    </div>
                                </div>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Admin</th>
                                                <th>Seller</th>
                                                <th>Rating</th>
                                                <th>Notes</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($ratings as $rating)
                                                <tr id="item-{{ $rating->id }}">
                                                    <td>{{ $rating->id }}</td>
                                                    <td>
                                                        @if($rating->admin)
                                                            {{ $rating->admin->name }}
                                                        @else
                                                            <span class="text-muted">Admin not found</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($rating->seller)
                                                            {{ $rating->seller->name }}
                                                        @else
                                                            <span class="text-muted">Seller not found</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $rating->rating)
                                                                <i class="mdi mdi-star text-warning"></i>
                                                            @else
                                                                <i class="mdi mdi-star-outline text-muted"></i>
                                                            @endif
                                                        @endfor
                                                        ({{ $rating->rating }}/5)
                                                    </td>
                                                    <td>{{ $rating->notes ?? '-' }}</td>
                                                    <td>{{ $rating->created_at->format('d M, Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.seller-ratings.edit', $rating->id) }}" class="action-icon">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                        <form action="{{ route('admin.seller-ratings.destroy', $rating->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action-icon border-0 bg-transparent" onclick="return confirm('Are you sure you want to delete this rating?')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No ratings found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    {{ $ratings->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('admin-src/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('admin-src/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admin-src/js/pages/datatables.init.js')}}"></script>
    <script src="{{asset('admin-src/libs/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#datatable').DataTable();
        });
    </script>
@endsection