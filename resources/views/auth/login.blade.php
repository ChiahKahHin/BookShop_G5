@extends("layouts.template")

@section("title")
	Login
@endsection

@section("navtitle")
	Login
@endsection

@section("content")
	<div class="card">
		<div class="card-body">
			<form action="{{ route("login") }}" method="post">
				@csrf
				<div class="form-group">
					<div class="row mb-3">
						<div class="col-sm-6 offset-sm-3">
							<label for="email">Email</label>
							<input type="text" name="email" class="form-control @error("email") border-warning @enderror" id="email" placeholder="e.g. example@gmail.com" value="{{ old("email") }}">
							@error("email")
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
								<input type="checkbox" name="rememberMe" class="form-check-input" id="rememberMe">
								<label for="rememberMe">Remember Me</label>
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
@endsection