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
                                <h6>Book Front Cover</h6>
                                <div class="text-center">
                                <img style="height: auto; width:50%;" class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                                </div>
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
                                <h6>{!! nl2br($stock->book_description) !!}</h6>
                            <br>

                            <h5>Book Trade Price (RM)</h5>
                                <h6>{{ $stock->book_trade_price }}</h6>
                            <br>

                            <h5>Book Retail Price (RM)</h5>
                                <h6>{{ $stock->book_retail_price }}</h6>
                            <br>

                            <h5>Book Quantity</h5>
                                <h6>{{ $stock->book_quantity }}</h6>
                            <br>

                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route("editStock", ['isbn' => $stock->book_isbn_no]) }}" class="btn bg-gradient-info w-100 mt-4 md-6">Edit</a>
                            </div>
                            <div class="col-md-6">
                                <button id="deleteBtnStock" class="btn bg-gradient-info w-100 mt-4 md-6" value="{{ $stock->book_isbn_no }}">Delete</button>
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

        // $.confirm({
		// 	title: '',
		// 	content: "Delete book?",
		// 	buttons: {
		// 		Yes: {
		// 			btnClass: 'btn-blue',
		// 			action: function() {
		// 				window.location.href = "/stock/delete/" + isbn;
		// 			}
		// 		},
		// 		Cancel: function() {

		// 		}
		// 	}
		// });
    }
	

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