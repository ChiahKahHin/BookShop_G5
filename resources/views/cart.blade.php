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
                <div class="col-3">
                    <h6>Book</h6>
                </div>
                <div class="col-2 text-center">
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

            @foreach (json_decode($cart) as $cartItem)
                @foreach ($stock as $stockItem)
                    @if($cartItem->book_isbn_no == $stockItem->book_isbn_no)
                        <div class="row">
                            <div class="col-1 text-center d-flex align-items-center justify-content-center">
                                <input type="checkbox" class="checkboxCart selectCartChk" name="selectCart" data-bookID="{{ $cartItem->book_isbn_no }}" id="{{'checkbox'.$stockItem->book_isbn_no}}" data-uTotalPrice="{{ $cartItem->book_retail_price*$cartItem->book_quantity }}">
                            </div>
                            <div class="col-2 text-center">
                                <img style="" class="img-thumbnail" src="data:image/png;base64,{{ chunk_split($cartItem->book_front_cover) }}">
                            </div>
                            <div class="col-3 d-flex align-content-between flex-wrap">
                                <div class="w-100">
                                    <a href="{{ route('stockDetails', ['isbn' => $cartItem->book_isbn_no]) }}"><h5>{{ $cartItem->book_name }}</h5></a> <label>by {{ $cartItem->book_author }}</label>
                                </div>
                                <div>
                                    <i class="fa fa-trash cart-delete deleteCartBtn" style="color: red;" id="{{ 'deleteCart'.$cartItem->book_isbn_no }}" 
                                        data-stockName="{{ $cartItem->book_name }}" data-cartId="{{ $cartItem->cart_id }}"> Delete Book</i>
                                    <p style="color: black;">ISBN: {{ $stockItem->book_isbn_no }}</p>   
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="input-group justify-content-center">
                                    <input type="button" value="-" class="button-minus" data-field="quantity">
                                    <input type="number" step="1" max="{{ $stockItem->book_quantity }}" value="{{ $cartItem->book_quantity }}" data-price="{{ $stockItem->book_retail_price }}" data-cartId="{{ $cartItem->cart_id }}" name="quantity" class="quantity-field validateEmpty"
                                        id="{{ 'bookQty' . $stockItem->book_isbn_no }}">
                                    <input type="button" value="+" class="button-plus" data-field="quantity" data-maxQty="{{ $stockItem->book_quantity }}">
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                RM{{ number_format($cartItem->book_retail_price, 2) }}
                            </div>
                            <div class="col-2 text-center" id="{{ 'subTotal'.$stockItem->book_isbn_no }}" name="itemSubtotal" data-subtotal="{{ number_format($cartItem->book_retail_price*$cartItem->book_quantity, 2) }}">
                                RM{{ number_format($cartItem->book_retail_price*$cartItem->book_quantity, 2) }}
                            </div>
                        </div>
                        <hr>
                        @php
                            $totalPrice += $cartItem->book_retail_price*$cartItem->book_quantity;
                        @endphp
                    @endif
                @endforeach
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
                    <h6 class="m-0" id="totalPriceCartValue">RM{{ number_format($totalPrice, 2) }}</h6>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end" style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ route('home') }}" class="btn bg-gradient-info mb-0">
            Continue Shopping
        </a>
        &nbsp;

        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <input type="hidden" value="" id="checkedBooks" name="selectedBooks">

            @if ($cart == "[]")
                <button type="submit" class="btn bg-gradient-info mb-0" disabled>
                    Proceed to Checkout
                </button>
            @else
                <button type="submit" class="btn bg-gradient-info mb-0" id="proceedCheckout">
                    Proceed to Checkout
                </button>   
            @endif

        </form>
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
        
        updateSelectedBooks();
    });

    function updateSelectedBooks(){
        var cartSelect = document.getElementsByName('selectCart');
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var selectedBooks = "";

            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    if(cartSelect[i].checked == true){
                        selectedBooks += (cartSelect[i].getAttribute('data-bookID') + ",");
                    }
                }
            }

        selectedBooks = selectedBooks.replace(/,\s*$/, "");
        console.log(selectedBooks);

        document.getElementById('checkedBooks').value = selectedBooks;
    }

    $(document).on('click', '.selectCartChk', function(){
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');
        var validateAll = true;

        var totalPriceCartValue = document.getElementById('totalPriceCartValue');

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
                totalPriceCartValue.innerHTML = "RM{{ number_format($totalPrice, 2) }}";
            } 
        }

        var totalUnitPrice = 0;
        for(var i=0; i < cartSelect.length; i++){
            if(cartSelect[i].type == 'checkbox'){
                if(cartSelect[i].checked == true){ 
                   totalUnitPrice += parseFloat($(cartSelect[i]).attr("data-uTotalPrice"));
                }
            }
        }
        totalPriceCartValue.innerHTML = "RM" + totalUnitPrice.toFixed(2);
        updateSelectedBooks();
    });

    $('#selectAllCartBtn').on('click', function(){
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');
        var totalPrice = 0;

        var totalPriceCartValue = document.getElementById('totalPriceCartValue');

        if(cartSelectAll.checked == true){
            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    cartSelect[i].checked = true;
                    totalPrice += parseFloat(cartSelect[i].getAttribute("data-uTotalPrice"));

                }
            }
            //totalPriceCartValue.innerHTML = "RM{{ number_format($totalPrice, 2) }}";
            totalPriceCartValue.innerHTML = "RM" + totalPrice.toFixed(2);
        }
        else{
            for(var i=0; i < cartSelect.length; i++){  
                if(cartSelect[i].type == 'checkbox'){
                    cartSelect[i].checked = false;
                }
            }
            totalPriceCartValue.innerHTML = "RM{{ number_format(0, 2) }}";
        }
        updateSelectedBooks();
    });

    $(document).on('click', '.deleteCartBtn', function (){
        var cartId = $(this).attr('data-cartId');
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
                Swal.fire({
					title: "Deleted!",
					text: "Deleted book with ISBN: " + bookID,
					icon: 'success',
					type: 'success',
					showConfirmButton: false,
					timer: 1500,
				}).then(function() {
					window.location.href = "/cart/deleteCartItem/" + cartId;
				});
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

<script>
    function incrementValue(e, maxValue) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            if(currentVal < maxValue){
                parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
            }
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 1) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
    }

    $('.input-group').on('click', '.button-plus', function(e) {
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');

        var maxValue = $(this).attr('data-maxQty');
        incrementValue(e, maxValue);

        var cartId = this.parentElement.getElementsByTagName('input')[1].getAttribute('data-cartId');
        var bookPrice = this.parentElement.getElementsByTagName('input')[1].getAttribute('data-price');
        var bookISBN =  this.parentElement.getElementsByTagName('input')[1].getAttribute('id').substring(7);
        var bookQty = this.parentElement.getElementsByTagName('input')[1].value;
        var subtotal = bookPrice * bookQty;

        document.getElementById('subTotal' + bookISBN).setAttribute('data-subtotal',subtotal.toFixed(2));
        document.getElementById('checkbox' + bookISBN).setAttribute('data-utotalprice',subtotal.toFixed(2));
        document.getElementById('subTotal' + bookISBN).innerHTML = "RM" + subtotal.toFixed(2);
        
        $.ajax({
            url: "{{ route('updateCartItemNumber') }}",
            data: {
                "cartId" : cartId,
                "bookQty" : bookQty,
                "_token": "{{ csrf_token() }}"
            },
            type: "POST"
        });

        var allSubtotal = document.getElementsByName('itemSubtotal');
        var totalPrice = 0;
        for(var i=0; i < allSubtotal.length; i++){
            totalPrice += parseFloat(allSubtotal[i].getAttribute('data-subtotal'));
        }
        if(cartSelectAll.checked == true || cartSelect.checked == true){
            document.getElementById('totalPriceCartValue').innerHTML = "RM" + totalPrice.toFixed(2);
        }
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
        var cartSelectAll = document.getElementById('selectAllCartBtn');
        var cartSelect = document.getElementsByName('selectCart');
        var cartId = this.parentElement.getElementsByTagName('input')[1].getAttribute('data-cartId');
        var bookPrice = this.parentElement.getElementsByTagName('input')[1].getAttribute('data-price');
        var bookISBN = this.parentElement.getElementsByTagName('input')[1].getAttribute('id').substring(7);
        var bookQty = this.parentElement.getElementsByTagName('input')[1].value;
        var subtotal = bookPrice * bookQty;

        document.getElementById('subTotal' + bookISBN).setAttribute('data-subtotal',subtotal.toFixed(2));
        document.getElementById('checkbox' + bookISBN).setAttribute('data-utotalprice',subtotal.toFixed(2));
        document.getElementById('subTotal' + bookISBN).innerHTML = "RM" + subtotal.toFixed(2);

        $.ajax({
            url: "{{ route('updateCartItemNumber') }}",
            data: {
                "cartId" : cartId,
                "bookQty" : bookQty,
                "_token": "{{ csrf_token() }}"
            },
            type: "POST"
        });

        var allSubtotal = document.getElementsByName('itemSubtotal');
        var totalPrice = 0;
        for(var i=0; i < allSubtotal.length; i++){
            console.log(parseFloat(allSubtotal[i].getAttribute('data-subtotal')));
            totalPrice += parseFloat(allSubtotal[i].getAttribute('data-subtotal'));
        }
        if(cartSelectAll.checked == true || cartSelect.checked == true){
            document.getElementById('totalPriceCartValue').innerHTML = "RM" + totalPrice.toFixed(2);
        }
    });

</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@endsection