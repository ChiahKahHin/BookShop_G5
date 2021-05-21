@extends("layouts.template")

@section('title')
    Admin | View Admin Details
@endsection

@section('navtitle')
    View Admin Details
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Admin Details</h6>
                        <p class="text-success">{{ session('message') }}</p>
                    </div>
                    <div class="card-body">
                    <h6>Username</h6>
                    <p>{{ $admins->username}}</p>
                    <h6>Phone Number</h6>
                    <p>{{ $admins->phone}}</p>
                    <h6>Email</h6>
                    <p>{{ $admins->email}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
