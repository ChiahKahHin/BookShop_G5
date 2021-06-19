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
                    <textarea class="form-control" id="address" name="address" rows="3">{!! nl2br(htmlentities(Auth::user()->address)) !!}</textarea>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" style="padding-right: 30px; font-size: 15px">Detected State: </span>
                            <input type="text" class="form-control" style="padding-left: 10px; font-size: 15px" id="state" name="state" readonly>
                            <span class="input-group-text" id="location"><i class="fas fa-crosshairs" style="font-size: 25px; cursor: pointer;"></i></span>
                        </div>
                    </div>
                    <input type="hidden" id="delivery_cost" name="delivery_cost">
                    <div class="d-inline m-auto">
                    </div>
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
                            <h6 class="m-0">RM <div id="deliveryCostValue">4.00</div></h6>
                        </div4.00>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <h6 class="m-0">Subtotal</h6>
                        </div>
                        <div class="col-1">
                            <h6 class="m-0">:</h6>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="m-0" id="totalPriceCartValue">RM {{ number_format($totalPrice, 2) }}</h6>
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

    $(document).ready(function() {
        let addressInput = document.getElementById("address");
        let tempInput = addressInput.innerHTML;
        let deliveryCostLabel = document.getElementById("deliveryCostValue");
        let deliveryCostInput = document.getElementById("delivery_cost");
        let stateInput = document.getElementById("state");
        setInterval(() => {
            let val = addressInput.value;
            if (val != "" && val != tempInput) {
                tempInput = val;
                let requestURL = "http://locationiq.com/v1/search.php";
                let param = {
                    key: "pk.432ad3be4e26d87d997f7b1e102c4236",
                    q: val,
                    countrycodes: "my",
                    addressdetails: 1,
                    "accept-language": "en",
                    format: "json"
                };
                $.getJSON(requestURL, param,
                    function (data) {
                        let state = "";
                        if (data.length > 0) {
                            let state = data[0]["address"]["state"];
                            $.get("{{ route("getState") }}", {q: state},
                                function (delivery_cost) {
                                    delivery_cost = parseFloat(delivery_cost);
                                    deliveryCostLabel.innerHTML = delivery_cost.toFixed(2);
                                    deliveryCostInput.value = delivery_cost;
                                    stateInput.value = state;
                                }
                            );
                        }
                    }
                ).fail(function() {
                    stateInput.value="Unable to get your location";
                });
            }
        }, 1000);

        $("#location").on("click", function () {
            navigator.geolocation.getCurrentPosition(function(position) {
                let requestURL = "https://locationiq.com/v1/reverse.php";
                let param = {
                    key: "pk.432ad3be4e26d87d997f7b1e102c4236",
                    "accept-language": "en",
                    lat: position.coords.latitude,
                    lon: position.coords.longitude,
                    format: "json"
                }
                $.getJSON(requestURL, param,
                    function (data, textStatus, jqXHR) {
                        let state = data["address"]["state"];
                        $.get("{{ route("getState") }}", {q: state},
                            function (delivery_cost) {
                                delivery_cost = parseFloat(delivery_cost);
                                deliveryCostLabel.innerHTML = delivery_cost.toFixed(2);
                                deliveryCostInput.value = delivery_cost;
                                stateInput.value = state;
                                addressInput.value = data["display_name"];
                            }
                        );
                    }
                );
            });
        });
    });
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@endsection