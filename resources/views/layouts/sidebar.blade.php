<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-left ms-3" id="sidenav-main">
	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
		<a class="navbar-brand m-0" href="{{ route('dashboard') }}">
			<img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100 w-15" alt="...">
			<span class="ms-1 font-weight-bold">Book Store</span>
		</a>
	</div>
	<hr class="horizontal dark mt-0">
	<div class="collapse navbar-collapse w-auto h-100" id="sidenav-collapse-main">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link @if (Route::currentRouteName() == "dashboard") active @endif" href="{{ route('dashboard') }}">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						🏠
					</div>
					<span class="nav-link-text ms-1">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="../pages/tables.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						📈
					</div>
					<span class="nav-link-text ms-1">Tables</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="../pages/billing.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						💳
					</div>
					<span class="nav-link-text ms-1">Billing</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="../pages/rtl.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						🛠
					</div>
					<span class="nav-link-text ms-1">RTL</span>
				</a>
			</li>
			<li class="nav-item mt-3">
				<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="../pages/profile.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						🙎‍♂️
					</div>
					<span class="nav-link-text ms-1">Profile</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="../pages/sign-in.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						🔐
					</div>
					<span class="nav-link-text ms-1">Change Password</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="../pages/sign-up.html">
					<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
						🚪
					</div>
					<span class="nav-link-text ms-1">Logout</span>
				</a>
			</li>
		</ul>
	</div>
</aside>