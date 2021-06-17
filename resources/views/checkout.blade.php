@extends("layouts.template")

@section("title")
    Shopping Cart
@endsection

@section('navtitle')
    Checkout
@endsection

@section("content")
<div class="text-center"><h3 class="mb-0">Checkout</h3></div>
<div class="container-fluid">
<div class="container-fluid">
<div class="container-fluid">
<div class="container-fluid">
<div class="container-fluid">
<div class="container-fluid py-4">

    <div class="row">

        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
        
                        </div>
                        <div class="col-5">
                            <h6>Book</h6>
                        </div>
                        <div class="col-1 text-center">
                            <h6>Quantity</h6>
                        </div>
                        <div class="col-2 text-center">
                            <h6>Price per Unit (RM)</h6>
                        </div>
                        <div class="col-2 text-center">
                            <h6>Total Price (RM)</h6>
                        </div>
                    </div>
                    <hr>
                    @php
                        $totalPrice = 0;
                    @endphp
                    @if ($cart == "[]")
                        <p class="text-center h4">The cart is empty</p>
                    @endif
                    @foreach (json_decode($cart) as $cart)
                        <div class="row">
                            <div class="col-2 text-center">
                                <img style="" class="img-thumbnail" src="data:image/png;base64,{{ chunk_split($cart->book_front_cover) }}">
                            </div>
                            <div class="col-5 d-flex align-content-between flex-wrap">
                                <div class="w-100">
                                    <a href="{{ route('stockDetails', ['isbn' => $cart->book_isbn_no]) }}"><h5>{{ $cart->book_name }}</h5></a> <label>by {{ $cart->book_author }}</label>
                                </div>
                                <div>
                                    <p style="color: black;">ISBN: {{ $cart->book_isbn_no }}</p>   
                                </div>
                            </div>
                            <div class="col-1 text-center">
                                {{ $cart->book_quantity }}
                            </div>
                            <div class="col-2 text-center">
                                RM{{ number_format($cart->book_retail_price, 2) }}
                            </div>
                            <div class="col-2 text-center">
                                RM{{ number_format($cart->book_retail_price*$cart->book_quantity, 2) }}
                            </div>
                        </div>
                        <hr>
                        @php
                            $totalPrice += $cart->book_retail_price*$cart->book_quantity;
                        @endphp
                    @endforeach
        
                </div>
            </div>
            <div class="card" style="margin-top: 20px;">
                <div class="card-body">
                    <h4>Delivery Address</h4>
                    <textarea class="form-control" rows="3" disabled></textarea>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-5">
                            <h6 class="m-0">Delivery cost</h6>
                        </div>
                        <div class="col-1">
                            <h6 class="m-0">:</h6>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="m-0" id="totalPriceCartValue">RM4.00</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <h6 class="m-0">Subtotal</h6>
                        </div>
                        <div class="col-1">
                            <h6 class="m-0">:</h6>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="m-0" id="totalPriceCartValue">RM{{ number_format($totalPrice, 2) }}</h6>
                        </div>
                    </div>
                    <br><br>
                    <button type="button" id="checkoutConfirm" class="btn bg-gradient-info mb-0 form-control">
                        Proceed to Checkout
                    </button>

                </div>
            </div>
        </div>
    </div>
    
    

</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@section("script")
<script>
    $('#checkoutConfirm').on('click', function(){
        Swal.fire({
            title: 'Are you sure you want to checkout?',
            icon: 'warning',
            icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#F00',
			confirmButtonColor: '#00F',
			confirmButtonText: 'Yes'
        }).then((result) => {
			if (result.value) {
                
            }
		});
    });


	var win = navigator.platform.indexOf('Win') > -1;
	if (win && document.querySelector('#sidenav-scrollbar')) {
		var options = {
			damping: '0.5'
		}
		Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
	}
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@endsection