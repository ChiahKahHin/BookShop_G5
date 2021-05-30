@extends("layouts.template")

@section("title")
Cart
@endsection

@section('navtitle')
<img src="../assets/img/book-icon.png" class="navbar-brand-img h-100 w-15" alt="...">
Book Shop
@endsection

@section("content")
<div class="text-center"><h3>Shopping Cart</h3></div>
<div class="container py-4">
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-1">

                </div>
                <div class="col-2">

                </div>
                <div class="col-4">
                    <h5>Book</h5>
                </div>
                <div class="col-2">
                    <h5>Price (RM)</h5>
                </div>
                <div class="col-2 text-center">
                    <h5>Quantity</h5>
                </div>
                <div class="col-1">
                </div>
            </div>
            <hr>

            @foreach (json_decode($cart) as $cart)
                <div class="row">
                    <div class="col-1 text-center">
                        <input type="checkbox" class="align-middle">
                    </div>
                    <div class="col-2 text-center">
                        <img style="" class="img-thumbnail" src="data:image/png;base64,{{ chunk_split($cart->book_front_cover) }}">
                    </div>
                    <div class="col-4">
                        <h4>{{ $cart->book_name }}</h4> <label>by {{ $cart->book_author }}</label>
                    </div>
                    <div class="col-2">
                        {{ $cart->book_retail_price }}
                    </div>
                    <div class="col-2 text-center">
                        {{ $cart->book_quantity }}
                    </div>
                    <div class="col-1 text-center">
                        <i class="fa fa-trash cart-delete deleteCartBtn" style="color: red;" id="{{ 'deleteCart'.$cart->book_isbn_no }}" 
                            data-stockName="{{ $cart->book_name }}"></i>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    

</div>
@endsection

@section("script")
<script>
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