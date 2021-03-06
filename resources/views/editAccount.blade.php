@extends("layouts.template")

@section('title')
    @if(Auth::user()->isCustomer())
        Customer | Edit Account
    @else
        Admin | Edit Account
    @endif
@endsection

@section('navtitle')
    Edit Account Info
@endsection

@section('content')
    <div class="@if(Auth::user()->isAdmin())container-fluid @else container @endif py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 @if(Auth::user()->isCustomer()) text-lg-center @endif">
                        <h6>My Account Details</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('editAccount') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                        <p class="text-success">{{ session('message') }}</p>
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
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
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
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
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
                                @if (Auth::user()->isCustomer())
                                <div class="row">
                                    <div class="col-md-6 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                    <label>Address</label><br>
                                    <textarea id="address" class="form-control" rows="2" cols="57" name="address" placeholder=" Please fill in your address" >{{ $admins->address }}</textarea>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                    <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Update Account</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection