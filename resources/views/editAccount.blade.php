@extends("layouts.template")

@section('title')
    Admin | Edit Account
@endsection

@section('navtitle')
    Edit Account Info
@endsection

@section('content')
<input type="hidden" name="id" value="{{ $admins->id }}">
<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>My Account Details</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('editAccount') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Username</label>
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') border-danger @enderror font-weight-bold"
                                            value="{{ $admins->username }}">
                                        @error('username')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                    <label>Phone number</label>
                                    <input type="text" name="phone" id="phone"
                                            class="form-control @error('phone') border-danger @enderror font-weight-bold" 
                                            value="{{ $admins->phone }}">
                                        @error('phone')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email"
                                            class="form-control @error('email') border-danger @enderror font-weight-bold"
                                            value="{{ $admins->email }}"
                                            autocomplete="off">
                                        @error('email')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Edit</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection