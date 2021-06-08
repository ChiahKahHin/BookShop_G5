@extends("layouts.template")

@section("title")
	Login
@endsection

@section("navtitle")
	Login
@endsection

@section("content")
	<div class="container">
		<div class="card">
			<div class="card-body">
				@if (session('status'))
					<div class="text-danger row mb-3 col-sm-6 offset-sm-3">{{ session('status') }}</div>
				@endif
				@if (session('message'))
					<div class="text-success row mb-3 col-sm-6 offset-sm-3">{{ session('message') }}</div>
				@endif
				<form action="{{ route("login") }}" method="post">
					@csrf
					<div class="form-group">
						<div class="row mb-3">
							<div class="col-sm-6 offset-sm-3">
								<label for="username">Username</label>
								<input type="text" name="username" class="form-control @error("username") border-warning @enderror" value="{{ old("username") }}" id="username" placeholder="e.g. Alexanda">
								@error("username")
								<div class="text-sm text-danger">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-6 offset-sm-3">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control @error("password") border-warning @enderror" id="password" placeholder="Password">
								@error("password")
								<div class="text-sm text-danger">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="row my-3">
							<div class="col-sm-6 offset-sm-3">
								<div class="form-check form-switch">
									<input type="checkbox" name="remember" class="form-check-input" id="remember" checked>
									<label for="remember">Remember Me</label>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-sm-6 offset-sm-3">
								<input type="submit" class="btn bg-gradient-info w-100" value="Login">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection