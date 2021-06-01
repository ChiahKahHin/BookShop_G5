@extends("layouts.template")

@section("title")
	Forget Password
@endsection

@section("navtitle")
	Forget Password
@endsection

@section("content")
	<div class="card">
		<div class="card-body">
			@if (session('message'))
				<div class="text-success row mb-3 col-sm-6 offset-sm-3">{{ session('message') }}</div>
			@endif
			<form action="{{ route("forgotPassword") }}" method="post">
				@csrf
				<div class="form-group">
					<div class="row mb-3">
						<div class="col-sm-6 offset-sm-3">
							<label for="email">Your Email</label>
							<input type="text" name="email" class="form-control @error("email") border-warning @enderror" id="email" placeholder="e.g. abc@example.com" value="{{ old("email") }}">
							@error("email")
								<div class="text-sm text-danger">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-sm-6 offset-sm-3">
							<input type="submit" class="btn bg-gradient-info w-100" value="Submit">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection