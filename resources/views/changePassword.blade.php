@extends("layouts.template")

@section('title')
    Change Password
@endsection

@section('navtitle')
    Change Password
@endsection

@section('content')
    <div class="@if(Auth::user()->isAdmin())container-fluid @else container @endif py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 @if(Auth::user()->isCustomer()) text-lg-center @endif">
                        <h6>Change Password</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('changePassword') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                        @if (session('status'))
                                            <p class="text-success">{{ session('status') }}</p>
                                        @endif
                                        <label>Old Password</label>
                                        <input type="password" name="oldPassword" id="oldPassword" class="form-control @error('oldPassword') border-danger @enderror">
                                        @error('oldPassword')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                        <label>New Password</label>
                                        <input type="password" name="password" id="password" class="form-control @error('password') border-danger @enderror">
                                        @error('password')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') border-danger @enderror">
                                        @error('password_confirmation')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 @if(Auth::user()->isCustomer()) offset-md-3 @endif">
                                    <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
