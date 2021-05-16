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
                                <img class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                            <h6>Book Name</h6>
                                <label>{{ $stock->book_name }}</label>
                            <br><br>

                            <h6>Book Author</h6>
                                <label>{{ $stock->book_author }}</label>
                            <br><br>

                            <h6>Book Publication Date</h6>
                                <label>{{ $stock->book_publication_date }}</label>
                            <br><br>

                            <h6>Book ISBN No.</h6>
                                <label>{{ $stock->book_isbn_no }}</label>
                            <br><br>

                            <h6>Book Description</h6>
                                <label>{{ $stock->book_description }}</label>
                            <br><br>

                            <h6>Book Trade Price (RM)</h6>
                                <label>{{ $stock->book_trade_price }}</label>
                            <br><br>

                            <h6>Book Retail Price (RM)</h6>
                                <label>{{ $stock->book_retail_price }}</label>
                            <br><br>

                            <h6>Book Quantity</h6>
                                <label>{{ $stock->book_quantity }}</label>
                            <br><br>

                            </div>
                        </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/editStock/#" class="btn bg-gradient-info w-100 mt-4 md-6">Edit</a>
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

        $.confirm({
			title: '',
			content: "Delete book?",
			buttons: {
				Yes: {
					btnClass: 'btn-blue',
					action: function() {
						window.location.href = "/stock/delete/" + isbn;
					}
				},
				Cancel: function() {

				}
			}
		});
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