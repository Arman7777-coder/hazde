@extends('admin.layouts.header-sidebar')

@section('title', 'Contact Request Details')

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
                                    <li class="breadcrumb-item"><a href="{{ route('admin.contact-requests.index') }}">Contact Requests</a></li>
                                    <li class="breadcrumb-item active">Request #{{ $contactRequest->id }}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contact Request Details</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Request #{{ $contactRequest->id }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Client Information</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Name:</strong></td>
                                                <td>{{ $contactRequest->first_name }} {{ $contactRequest->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $contactRequest->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ $contactRequest->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Wedding Date:</strong></td>
                                                <td>{{ $contactRequest->wedding_date ? $contactRequest->wedding_date->format('Y-m-d') : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h5>Request Status</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if($contactRequest->is_replied)
                                                        <span class="badge bg-success">Replied</span>
                                                    @elseif($contactRequest->is_read)
                                                        <span class="badge bg-warning">Read</span>
                                                    @else
                                                        <span class="badge bg-primary">New</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Created At:</strong></td>
                                                <td>{{ $contactRequest->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated:</strong></td>
                                                <td>{{ $contactRequest->updated_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Message</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                <p>{{ $contactRequest->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$contactRequest->is_replied)
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>Reply to Client</h5>
                                        <form method="POST" action="{{ route('admin.contact-requests.reply', $contactRequest) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="reply_message" class="form-label">Your Reply</label>
                                                <textarea class="form-control" id="reply_message" name="reply_message" rows="5" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Send Reply</button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="alert alert-success">
                                            <h5>Replied to Client</h5>
                                            <p>This request has been replied to.</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.contact-requests.index') }}" class="btn btn-secondary">Back to Requests</a>
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