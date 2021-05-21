@extends("layouts.template")
@section("title")
	Register
@endsection

@section("navtitle")
	Register
@endsection

@section("content")
<div class="card">
	<div class="card-body">
		<form action="{{ route("register") }}" method="post">
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
						<label for="username">Username</label>
						<input type="text" name="username" class="form-control @error("username") border-warning @enderror" id="username" placeholder="e.g. Alexanda" value="{{ old("username") }}">
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
				<div class="row mb-3">
					<div class="col-sm-6 offset-sm-3">
						<label for="password_confirmation">Confirm Password</label>
						<input type="password" name="password_confirmation" class="form-control @error("password_confirmation") border-warning @enderror" id="password_confirmation" placeholder="Confirm Password">
						@error("password_confirmation")
							<div class="text-sm text-danger">
								{{ $message }}
							</div>
						@enderror
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-sm-6 offset-sm-3">
						<input type="submit" class="btn bg-gradient-info w-100" value="Register">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection