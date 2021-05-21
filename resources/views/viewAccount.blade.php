@extends("layouts.template")

@section('title')
    Admin | View Account
@endsection

@section('navtitle')
    Account Info
@endsection

@section('content')
<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>My Account Details</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('viewAccount') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <p class="text-md text-dark mb-0 px-2">Username</p>
                                        <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $admins->username }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark mb-0 px-2">Phone number</p>
                                        <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $admins->phone }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark mb-0 px-2">Email</p>
                                        <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $admins->email }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <a class="btn bg-gradient-info w-100 mt-4 md-6" href="{{ route('editAccount') }}">Edit Account Info</a>
                                </div>
                            </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection