@extends('admin.layouts.header-sidebar')

@section('title', 'Contact Requests')

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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                    <li class="breadcrumb-item active">Contact Requests</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contact Requests</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">All Contact Requests</h4>
                                
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Wedding Date</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($contactRequests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->first_name }} {{ $request->last_name }}</td>
                                            <td>{{ $request->email }}</td>
                                            <td>{{ $request->phone ?? 'N/A' }}</td>
                                            <td>{{ $request->wedding_date ? $request->wedding_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td>
                                                @if($request->is_replied)
                                                    <span class="badge bg-success">Replied</span>
                                                @elseif($request->is_read)
                                                    <span class="badge bg-warning">Read</span>
                                                @else
                                                    <span class="badge bg-primary">New</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.contact-requests.show', $request) }}" class="btn btn-info">
                                                    <span class="mdi mdi-eye"></span> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    <script src="{{asset('admin-src/js/pages/datatables.init.js')}}"></script>
@endsection