@extends("layouts.template")

@section("title")
	Reset Password
@endsection

@section("navtitle")
	Reset Password
@endsection

@section("content")
	<div class="container py-4">
		<div class="card">
			<div class="card-body">
				@if (session('status'))
					<div class="text-danger row mb-3 col-sm-6 offset-sm-3">{{ session('status') }}</div>
				@endif
				<form action="{{ route("password.reset", ['token' => $token]) }}" method="post">
					@csrf
					<div class="form-group">
						<div class="row mb-3">
							<div class="col-sm-6 offset-sm-3">
								<label for="email">Email</label>
								<input type="hidden" name="token" id="token" value="{{ $token }}">
								<input type="email" name="email" class="form-control @error("email") border-warning @enderror" id="email">
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
								<input type="password" name="password" class="form-control @error("password") border-warning @enderror" id="password">
								@error("password")
									<div class="text-sm text-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-6 offset-sm-3">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" name="password_confirmation" class="form-control @error("password_confirmation") border-warning @enderror" id="password_confirmation">
								@error("password_confirmation")
									<div class="text-sm text-danger">
										{{ $message }}
									</div>
								@enderror
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-sm-6 offset-sm-3">
								<input type="submit" class="btn bg-gradient-info w-100" value="Reset Password">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection