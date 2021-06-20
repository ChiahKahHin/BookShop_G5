<!DOCTYPE html>
<html lang="en">
	<head>
		@include("layouts.head")
		<title>@yield('title')</title>
	</head>
	<body class="g-sidenav-show bg-gray-100">
		@if (Auth::check() && Auth::user()->isAdmin())
			@include('layouts.sidebar')
		@endif
		<main class="main-content mt-1 border-radius-lg">
			<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
				<div class="container-fluid py-1 px-3">
					<a href="{{ route('home') }}" style="letter-spacing: 0;">
						<h6 class="font-weight-bolder mb-0">
							@if (Auth::check() && Auth::user()->isCustomer() || !Auth::check())
								<img src="../assets/img/book-icon.png" class="navbar-brand-img h-100 w-10" alt="...">
								Book Shop |
							@endif
							@yield("navtitle")
						</h6>
					</a>
					@include('layouts.nav')
				</div>
			</nav>

			@if (Route::currentRouteName() == "home")
				@yield("carouselSlides")
			@endif
			
			<div class="container-fluid py-4">
				@yield("content")
			
				@include("layouts.footer")
			</div>
		</div>
		@include("layouts.script")
		@yield("script")
	</body>
</html>