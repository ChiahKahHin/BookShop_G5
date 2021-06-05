@extends("layouts.template")

@section("title")
    Shopping Cart
@endsection

@section('navtitle')
    Shopping Cart
@endsection

@section("content")
<div class="text-center"><h3 class="mb-0">Shopping Cart</h3></div>

<div class="container py-4">
    {{-- <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ route('home') }}" class="btn bg-gradient-info mb-0">
            Continue Shopping
        </a>
    </div> --}}
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-1">

                </div>
                <div class="col-2">

                </div>
                <div class="col-4">
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
            <div style="display: none">{{ $totalPrice = 0 }}</div>
            @foreach (json_decode($cart) as $cart)
                <div class="row">
                    <div class="col-1 text-center d-flex align-items-center justify-content-center">
                        <input type="checkbox" class="checkboxCart selectCartChk" name="selectCart" value="">
                    </div>
                    <div class="col-2 text-center">
                        <img style="" class="img-thumbnail" src="data:image/png;base64,{{ chunk_split($cart->book_front_cover) }}">
                    </div>
                    <div class="col-4 d-flex align-content-between flex-wrap">
                        <div class="w-100">
                            <h5>{{ $cart->book_name }}</h5> <label>by {{ $cart->book_author }}</label>
                        </div>
                        <div>
                            <i class="fa fa-trash cart-delete deleteCartBtn" style="color: red;" id="{{ 'deleteCart'.$cart->book_isbn_no }}" 
                                data-stockName="{{ $cart->book_name }}"> Delete Book</i>

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
                <div style="display: none">{{ $totalPrice += $cart->book_retail_price*$cart->book_quantity }}</div>
            @endforeach

            <div class="row">
                <div class="col-1 text-center d-flex align-items-center justify-content-center">
                    <input type="checkbox" class="checkboxCart" name="selectAllCart" id="selectAllCartBtn">
                </div>
                <div class="col-2">
                </div>
                <div class="col-4">
                </div>
                <div class="col-1 text-center">
                </div>
                <div class="col-2 text-end">
                    <h6 class="m-0">Subtotal:</h6>
                </div>
                <div class="col-2 text-center">
                    RM{{ number_format($totalPrice, 2) }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ route('home') }}" class="btn bg-gradient-info mb-0">
            Continue Shopping
        </a>
    </div>

</div>
@endsection

@section("script")
<script>
    $(document).ready(function (){
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');

        for(var i=0; i < cartSelect.length; i++){  
            if(cartSelect[i].type == 'checkbox'){
                cartSelect[i].checked = true;
            }
        }
        cartSelectAll.checked = true;
    });

    $(document).on('click', '.selectCartChk', function(){
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');
        var validateAll = true;
        if(cartSelectAll.checked == true){
            cartSelectAll.checked = false;
        }
        else{
            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    if(cartSelect[i].checked == false){
                        validateAll = false;
                    }
                }
            }
            if(validateAll){
                cartSelectAll.checked = true;
            } 
        }
    });

    $('#selectAllCartBtn').on('click', function(){
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');

        if(cartSelectAll.checked == true){
            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    cartSelect[i].checked = true;
                }
            }
        }
        else{
            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    cartSelect[i].checked = false;
                }
            }  
        }
    });

    $(document).on('click', '.deleteCartBtn', function (){
        var bookID = $(this).attr('id').substring(10);
        var bookName = $(this).attr("data-stockName");
        console.log(bookID);
        console.log(bookName);
        Swal.fire({
			title: 'Remove from Cart?',
			text: bookName ,
			icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#F00',
			confirmButtonColor: '#00F',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.value) {
				// Swal.fire({
				// 	title: "Deleted!",
				// 	text: "Deleted book with ISBN: " + stockISBN,
				// 	icon: 'success',
				// 	type: 'success',
				// 	showConfirmButton: false,
				// 	timer: 1500,
				// }).then(function() {
				// 	window.location.href = "/dashboard/delete/" + stockISBN;
				// });

				// $.ajax({
				// 	type: "POST",
				// 	dataType: "json",
				// 	url: " route('dashboardDelete') ",
				// 	data: {
				// 		"_token": "csrf_token()",
				// 		"stockISBN": stockISBN
				// 	},
				// 	success: function(data) {
				// 		console.log("success");
				// 		$('#stockTable').DataTable().ajax.reload(null, false);
				// 		//$('#dashboardCard').html(data);
				// 		console.log(data);
				// 	}
				// });
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