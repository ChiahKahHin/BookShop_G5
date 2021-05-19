@extends("layouts.template")

@section("title")
Dashboard
@endsection

@section('navtitle')
Dashboard
@endsection

@section("content")
<div class="container-fluid py-4">


	<div class="row">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header pb-0">
					<div>
						<div class="float-end">
							<a class="btn bg-gradient-info mb-0 form-control" href="/addStock">Add New Stock</a>
						</div>
					</div>
				</div>
				<div class="card-body">

					<table id="stockTable" class="display">
						<thead>
							<tr>
								<th style="width: 15%"></th>
								<th style="width: 30%">Title</th>
								<th style="width: 20%">ISBN</th>
								<th class="text-center" style="width: 15%">Quantity</th>
								<th class="text-center" style="width: 10%">Action</th>
								<th class="text-center" style="width: 10%">View</th>
							</tr>
						</thead>
						<tbody>
							@foreach($stock as $stock)
							<tr>
								<td><img class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}"></td>
								<td>{{ $stock->book_name }}</td>
								<td>{{ $stock->getRawOriginal("book_isbn_no") }}</td>
								<td class="align-middle text-center">{{ $stock->book_quantity }}</td>
								<td class="align-middle text-center">
									<i class="material-icons btn-stock-action" style="color: blue">mode_edit<a href="#"></a></i>
									<i class="material-icons btn-stock-action deleteStockList" style="color: blue" id="{{ $stock->book_isbn_no }}" value="{{ $stock->book_isbn_no }}">delete</i>
									<!-- <button class="btn btn-primary btn-stock-delete"><i class="fa fa-trash"></i> Delete</button> -->
								</td>
								<td class="align-middle text-center"><a class="btn bg-gradient-info mb-0" href="/stock/{{ $stock->getRawOriginal('book_isbn_no') }}">View</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection

@section("script")
<script>
	$(document).ready(function() {
		$('#stockTable').DataTable();
	});

	$(document).on('click', '.deleteStockList', function() {
		var stockISBN = $(this).attr('id');
		$.confirm({
			title: 'Delete Book ISBN',
			content: '<b>' + stockISBN + '</b>',
			buttons: {
				Yes: {
					btnClass: 'btn-blue',
					action: function() {
						window.location.href = "/dashboard/" + stockISBN;
					}
				},
				Cancel: function() {

				}
			}
		});
	});

	// function deleteStock(isbn) {
	// 	$.confirm({
	// 		title: 'Delete Book ISBN',
	// 		content: '<b>' + isbn + '</b>',
	// 		buttons: {
	// 			Yes: {
	// 				btnClass: 'btn-blue',
	// 				action: function() {
	// 					// $.post('/' + isbn, function() {
	// 					// });
	// 					// $.ajax({
	// 					// 	type: "DELETE",
	// 					// 	dataType: "json",
	// 					// 	url: "/" + isbn,
	// 					// 	data: {
	// 					// 		"_token": "{{ csrf_token() }}"
	// 					// 	},
	// 					// 	success: function(data) {
	// 					// 		//data = JSON.parse(data);

	// 					// 		$('#stockTable').DataTable().ajax.reload(null, false);
	// 					// 		//console.log(data);
	// 					// 	},
	// 					// 	error: function(data) {
	// 					// 		//data = JSON.parse(data);
	// 					// 		$('#stockTable').DataTable().ajax.reload(null, false);
	// 					// 		//console.log(data);
	// 					// 	}
	// 					// });
	// 					window.location.href = "/" + isbn;

	// 				}
	// 			},
	// 			Cancel: function() {

	// 			}
	// 		}
	// 	});
	// }

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