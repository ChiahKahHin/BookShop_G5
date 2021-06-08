@extends("layouts.template")

@section('title')
    Customer | Customer Registration
@endsection

@section('navtitle')
    User Registration
@endsection

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 text-lg-center">
                        <h6>Account Registration</h6>
                        <p class="text-success">{{ session('message') }}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customerRegistration') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <label>Username</label>
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') border-danger @enderror"
                                            placeholder="e.g. Peter" value="{{ old('username') }}">
                                        @error('username')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone" id="phone"
                                            class="form-control @error('phone') border-danger @enderror"
                                            placeholder="e.g. 012-3456789" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') border-danger @enderror"
                                            placeholder="e.g. peter@gmail.com" value="{{ old('email') }}"
                                            autocomplete="off">
                                        @error('email')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <label>Password</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') border-danger @enderror"
                                            placeholder="Please enter password">
                                        @error('password')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control @error('password_confirmation') border-danger @enderror"
                                            placeholder="Please enter confirm password">
                                        @error('password_confirmation')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Register</button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 text-center offset-md-3">
                                <a href="{{ route('login') }}">Already have an account ? Login now !</a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
