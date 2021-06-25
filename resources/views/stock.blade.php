@extends("layouts.template")

@section("title")
{{ $stock->book_name }}
@endsection

@section('navtitle')
Book Details
@endsection

@section("content")
	<div class="container-fluid py-4">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header pb-0">
						<a href="{{ route("home") }}"><i class="fa fa-arrow-left"></i> &nbsp;Back</a>
					</div>
					<div class="card-body">
						@if (session("message"))
							<div class="row ms-8">
								<div class="text-success text-center mb-5">{{ session('message') }}</div>
							</div>
						@endif
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

                            @if (!is_null($stock->comments()->avg("rating")))
                                <h5>Rating</h5>
                                    <h6>{{ number_format($stock->comments()->avg("rating"), 1) }}</h6>
                                <br>
                            @endif

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
					<hr>
					<div class="text-left @if (Auth::check() && !Auth::user()->isAdmin() || !Auth::check()) mx-8 @endif">
						<div class="card-body">
							<p class="h5">Ratings & Comments</p>
							@auth
								@if (Auth::user()->isCustomer())
                                    <form action="{{ route(is_null($userComment) ? "addcomment": "editcomment", $stock->book_isbn_no) }}" id="comment-form" method="post" enctype="multipart/form-data" >
                                        @csrf
                                        <div class="rate" id="comment-rating">
                                            <input type="radio" id="star5" name="rate" value="5" @if (!is_null($userComment) && $userComment->rating == 5) checked @endif @if(!is_null($userComment)) disabled="disabled" @endif>
                                            <label for="star5">5 stars</label>
                                            <input type="radio" id="star4" name="rate" value="4" @if (!is_null($userComment) && $userComment->rating == 4) checked @endif @if(!is_null($userComment)) disabled="disabled" @endif>
                                            <label for="star4">4 stars</label>
                                            <input type="radio" id="star3" name="rate" value="3" @if (!is_null($userComment) && $userComment->rating == 3) checked @endif @if(!is_null($userComment)) disabled="disabled" @endif>
                                            <label for="star3">3 stars</label>
                                            <input type="radio" id="star2" name="rate" value="2" @if (!is_null($userComment) && $userComment->rating == 2) checked @endif @if(!is_null($userComment)) disabled="disabled" @endif>
                                            <label for="star2">2 stars</label>
                                            <input type="radio" id="star1" name="rate" value="1" @if (!is_null($userComment) && $userComment->rating == 1 || is_null($userComment)) checked @endif @if(!is_null($userComment)) disabled="disabled" @endif>
                                            <label for="star1">1 star</label>
                                        </div>
                                        @if (!is_null($userComment))
                                            <div style="float: right" id="comment-edit-button">
                                                <button class="btn bg-gradient-info rounded-3" type="button"><i class="fas fa-edit"></i> Edit</button>
                                            </div>
                                        @endif
                                        <textarea name="content" id="content" cols="30" rows="4" class="border-2 w-100 rounded-3 @error("body") border-warning @enderror" placeholder="Leave a comment (Optional)" @if(!is_null($userComment)) disabled="disabled" @endif>{{ !is_null($userComment) ? $userComment->content : "" }}</textarea>
										<label for="attachment">Upload attachment <i>(Only attachment with .jpg, .png, .jpeg, .mp3, .m4a, .mp4 extension can be accepted) (Optional)</i></label>
										<input type="file" class="form-control" name="attachment" id="attachment" @if(!is_null($userComment)) disabled="disabled" @endif>
										@error("attachment")
											<div class="text-sm text-danger">
												{{ $message }}
											</div>
										@enderror
										<div class="text-right mt-4 {{ !is_null($userComment) ? "d-none" : "" }}" id="comment-add-button">
											<button class="btn bg-gradient-info rounded-3" type="submit"><i class="fas fa-paper-plane"></i> {{ is_null($userComment) ? "Post" : "Update" }}</button>
										</div>
									</form>
								@endif
							@endauth
							<hr>
							@php
								$comments = $stock->comments;
							@endphp
							@if ($comments->count() > 0)
								@foreach ($comments as $comment)
								<div class="row">
									<div class="col-12">
										<div class="font-weight-bold d-inline me-2" style="color: black">{{ $comment->user->username }}</div>
										<span class="text-sm">{{ $comment->updated_at->diffForHumans() }}</span>
										<div class="rate-display mt-1">
											<label for="star5" @if ($comment->rating == 1) class="checked" @endif>1 star</label>
											<label for="star4" @if ($comment->rating == 2) class="checked" @endif>2 stars</label>
											<label for="star3" @if ($comment->rating == 3) class="checked" @endif>3 stars</label>
											<label for="star2" @if ($comment->rating == 4) class="checked" @endif>4 stars</label>
											<label for="star1" @if ($comment->rating == 5) class="checked" @endif>5 stars</label>
										</div>
										<p style="color: black">{!! nl2br(htmlentities($comment->content)) !!}</p>
									</div>
									<div class="col-12 mb-4">
										@if (!is_null($comment->mimeType))
											@if (Str::startsWith($comment->mimeType, 'image'))
												<img style="height: 150px" src="data:{{ $comment->mimeType }};base64,{{ chunk_split(base64_encode($comment->attachment)) }}" alt="Failed Image">
											@elseif (Str::startsWith($comment->mimeType, 'audio'))
												<audio src="data:{{ $comment->mimeType }};base64,{{ chunk_split(base64_encode($comment->attachment)) }}" alt="Failed Image" controls></audio>
											@else
												<video style="height: 150px" src="data:{{ $comment->mimeType }};base64,{{ chunk_split(base64_encode($comment->attachment)) }}" alt="Failed Image" controls></video>
											@endif
										@endif
									</div>
									<hr>
								</div>
								@endforeach
								<p>Showing {{ $comments->firstItem() }} to {{ $comments->lastItem() }} of {{ $comments->total() }} {{ Str::plural("result", $comments->total()) }}</p>
								@php
									$urlRange = $comments->getUrlRange(1, $comments->lastPage());
								@endphp
								<ul class="pagination justify-content-center">
									<li class="page-item @if (is_null($comments->previousPageUrl()))disabled @endif">
										<a class="page-link" href="{{ $comments->previousPageUrl() }}" tabindex="-1">
											<i class="fa fa-angle-left"></i>
											<span class="sr-only">Previous</span>
										</a>
									</li>
									@foreach ($urlRange as $i => $url)
										<li class="page-item @if ($comments->currentPage() == $i) active @endif">
											<a class="page-link" href="{{ $url }}">{{ $i }}</a>
										</li>
									@endforeach
									<li class="page-item @if (is_null($comments->nextPageUrl()))disabled @endif">
										<a class="page-link" href="{{ $comments->nextPageUrl() }}">
											<i class="fa fa-angle-right"></i>
											<span class="sr-only">Next</span>
										</a>
									</li>
								</ul>
							@else
							<p>there are no comment</p>
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
    @elseif (Auth::check() && Auth::user()->isCustomer() && !is_null($userComment))
        $(document).ready(function () {
            $("#comment-edit-button button").on("click", function () {
                $("#comment-add-button")[0].classList.remove("d-none");
                $("#comment-edit-button")[0].classList.add("d-none")
                $("#attachment")[0].removeAttribute("disabled");
                $("#content")[0].removeAttribute("disabled");
                $("#comment-rating input[name='rate']").each(function (index, element) {
                    element.removeAttribute("disabled");
                });
            });
        });
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
