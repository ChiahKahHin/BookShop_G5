<!DOCTYPE html>
<html lang="en">
	<head>
		@include("layouts.head")
		<title>@yield('title')</title>
	</head>
	<body class="g-sidenav-show bg-gray-100">
		@include('layouts.sidebar')
		<main class="main-content mt-1 border-radius-lg">
			<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
				<div class="container-fluid py-1 px-3">
					<h6 class="font-weight-bolder mb-0">@yield("navtitle")</h6>
					@include('layouts.nav')
				</div>
			</nav>
			
			<div class="container-fluid py-4">
				@yield("content")
			
				@include("layouts.footer")
			</div>
		</div>
		@include("layouts.script")
		<script>@yield("script")</script>
	</body>
</html>