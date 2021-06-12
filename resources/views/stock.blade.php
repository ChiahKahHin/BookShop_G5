@extends("layouts.template")

@section("title")
ISBN: {{ $stock->book_isbn_no }}
@endsection

@section('navtitle')
Book Details
@endsection

@section("content")
<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <a href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i> &nbsp;Back</a>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="text-center">
                                    <h6>Book Front Cover</h6>
                                    <img style="height: auto; width:50%;" class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                                </div>
                                @if(Auth::check() && Auth::user()->isCustomer())
                                    @if($stock->book_quantity <= 0)
                                    <div class="input-group justify-content-center">
                                        <input type="button" value="-" class="button-minus" data-field="quantity" disabled>
                                        <input type="number" step="1" max="{{ $stock->book_quantity }}" value="1" name="quantity" class="quantity-field validateEmpty"
                                            id="{{ 'bookQty' . $stock->book_isbn_no }}" disabled>
                                        <input type="button" value="+" class="button-plus" data-field="quantity" data-maxQty="{{ $stock->book_quantity }}" disabled>
                                    </div>
                                    <center><button type="button" class="btn bg-gradient-info mb-0" disabled><i class="fa fa-shopping-cart"></i> Out of Stock</button></center>
                                    @else
                                        <div class="input-group justify-content-center">
                                            <input type="button" value="-" class="button-minus" data-field="quantity">
                                            <input type="number" step="1" max="{{ $stock->book_quantity }}" value="1" name="quantity" class="quantity-field validateEmpty"
                                                id="{{ 'bookQty' . $stock->book_isbn_no }}">
                                            <input type="button" value="+" class="button-plus" data-field="quantity" data-maxQty="{{ $stock->book_quantity }}">
                                        </div>
                                        <center><button type="button" class="btn bg-gradient-info mb-0 addBookToCart"
                                            data-bookName="{{ $stock->book_name }}" value="{{ $stock->book_isbn_no }}"><i
                                                class="fa fa-shopping-cart"></i> Add to Cart</button></center>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-6 mb-4">
                            <h5>Book Name</h5>
                                <h6>{{ $stock->book_name }}</h6>
                            <br>

                            <h5>Book Author</h5>
                                <h6>{{ $stock->book_author }}</h6>
                            <br>

                            <h5>Book Publication Date</h5>
                                <h6>{{ $stock->book_publication_date }}</h6>
                            <br>

                            <h5>Book ISBN No.</h5>
                                <h6>{{ $stock->book_isbn_no }}</h6>
                            <br>

                            <h5>Book Description</h5>
                                <h6 class="text-justify">{!! nl2br($stock->book_description) !!}</h6>
                            <br>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <h5>Book Trade Price (RM)</h5>
                                    <h6>{{ number_format($stock->book_trade_price, 2) }}</h6>
                                <br>

                                <h5>Book Retail Price (RM)</h5>
                                    <h6>{{ number_format($stock->book_retail_price, 2) }}</h6>
                                <br>
                            @else
                                <h5>Book Sales Price (RM)</h5>
                                    <h6>{{ number_format($stock->book_retail_price, 2) }}</h6>
                                <br>
                            @endif

                            <h5>Book Quantity</h5>
                                <h6>{{ $stock->book_quantity }}</h6>
                            <br>

                            </div>
                        </div>
                        <div class="row">
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <div class="col-md-6">
                                    <a href="{{ route("editStock", ['isbn' => $stock->book_isbn_no]) }}" class="btn bg-gradient-info w-100 mt-4 md-6">Edit</a>
                                </div>
                                <div class="col-md-6">
                                    <button id="deleteBtnStock" class="btn bg-gradient-info w-100 mt-4 md-6" value="{{ $stock->book_isbn_no }}">Delete</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
<script>

    @if(Auth::check() && Auth::user()->isAdmin())
        document.getElementById("deleteBtnStock").addEventListener("click", deleteStock);

        function deleteStock(){
            var isbn = document.getElementById("deleteBtnStock").value;

            Swal.fire({
                title: 'Delete Book?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#F00',
                confirmButtonColor: '#00F',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Deleted book with ISBN: " + isbn,
                        icon: 'success',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/stock/delete/" + isbn;
                    });
                }
            });
        }

    @else
        $(document).on('click', '.addBookToCart', function() {
            var stockISBN = $(this).attr('value');
            var qtyBtn = "bookQty" + stockISBN;
            var quantity = document.getElementById(qtyBtn).value;
            var bookName = $(this).attr('data-bookName');

            console.log(stockISBN);
            console.log(qtyBtn);
            console.log(quantity);
            console.log(bookName);

            $.ajax({
                type: "POST",
                dataType: "text",
                url: "{{ route('addToCart') }}",
                data: {
                    "userID": {{ Auth::id() }},
                    "_token": "{{ csrf_token() }}",
                    "stockISBN": stockISBN,
                    "stockQty": quantity
                },
                success: function(data) {
                    if(data == "success"){
                        Swal.fire({
                            title: 'Book Added',
                            text: bookName,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function (){
                            window.location.href = "/cart";
                        });
                    }
                    else if(data == "sameAmount"){
                        Swal.fire({
                            title: 'Failed to Add',
                            html: bookName + "<br>" + "Quantity added to cart is at maximum!",
                            icon: 'error',
                            timer: 4000,
                            showConfirmButton: false
                        });
                    }
                    else{
                        Swal.fire({
                            title: 'Some Book Added',
                            html: bookName + "<br>Maximum Quantity Reached!<br>Only " + data + " book(s) added",
                            icon: 'error',
                            timer: 4000,
                            showConfirmButton: false
                        }).then(function (){
                            window.location.href = "/cart";
                        });
                    }
                }
            });
        });

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
            var maxValue = $(this).attr('data-maxQty');
            incrementValue(e, maxValue);
        });

        $('.input-group').on('click', '.button-minus', function(e) {
            decrementValue(e);
        });
    @endif

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