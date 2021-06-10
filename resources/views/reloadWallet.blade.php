@extends("layouts.template")

@section('title')
    Customer | Reload Wallet
@endsection

@section('navtitle')
    Reload Wallet
@endsection

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 text-lg-center">
                        <h6>Reload Wallet</h6>
                    </div>
                    <div class="card-body">
                        <form id="addStockForm" action="{{ route('reloadWallet') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4 offset-md-3">
                                        <p class="text-success">{{ session('message') }}</p>
                                        <label>Reload Amount</label><br>

											<input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-1" value="10" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-1">
												<span data-hover="RM10">RM10</span>
											</label>
											
											<input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-2" value="20" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-2">
												<span data-hover="RM20">RM20</span>
											</label>

										    <input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-3" value="50" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-3">
												<span data-hover="RM50">RM50</span>
											</label>   
										    <input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-4" value="100" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-4">
												<span data-hover="RM100">RM100</span>
											</label>

										    <input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-5" value="200" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-5">
												<span data-hover="RM200">RM200</span>
											</label>

										    <input class="checkbox-amountReload" type="radio" name="amountReload" id="amountReload-6" value="500" onclick="enableReload()">
											<label class="for-checkbox-amountReload" for="amountReload-6">
												<span data-hover="RM500">RM500</span>
											</label>

                                        @error('reload_amount')
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
                                            placeholder="Enter your account password">
                                        @error('password')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <button class="btn bg-gradient-info w-100 mt-4 md-6" id="btnReload" type="submit" disabled>Reload Wallet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
        <script src="http://code.jquery.com/jquery-1.5.js"></script>
        <script>
			function enableReload(){
				var btnReload = document.getElementById("btnReload");
				btnReload.disabled = false;
			}
        </script>
    @endsection
