@extends("layouts.template")

@section("title")
Dashboard
@endsection

@section('navtitle')
Dashboard
@endsection

@section("content")
<div class="container-fluid py-4">
	<table id="stockTable" class="display cell-border">
		<thead>
			<tr>
				<th style="width: 30%">Title</th>
				<th style="width: 20%">Author</th>
				<th style="width: 15%">ISBN</th>
				<th style="width: 10%">Price</th>
				<th style="width: 10%">Quantity</th>
				<th style="width: 15%">Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($stock as $stock)
			<tr>
				<td>{{ $stock->book_name }}</td>
				<td>{{ $stock->book_author }}</td>
				<td>{{ $stock->book_isbn_no }}</td>
				<td>{{ $stock->book_retail_price }}</td>
				<td>{{ $stock->book_quantity }}</td>
				<td>
					<a class="btn btn-primary btn-stock-view" href="/stock/{{ $stock->book_isbn_no }}"><i class="fa fa-arrow-right"></i> View</a>&nbsp;&nbsp;
					<button class="btn btn-primary btn-stock-delete" onclick="deleteStock({{ $stock->book_isbn_no }})" value="{{ $stock->book_isbn_no }}">
					<i class="fa fa-trash"></i> Delete</button>
					<!-- <form action="/{{ $stock->book_isbn_no }}" method="POST">
						@csrf
						@method('DELETE')
					</form> -->
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>



</div>
@endsection

@section("script")
<script>
	$(document).ready(function() {
		$('#stockTable').DataTable();
	});

	function deleteStock(isbn) {
		console.log(isbn);
		$.confirm({
			title: 'Delete Book ISBN',
			content: '<b>' + isbn + '</b>',
			buttons: {
				Yes: {
					btnClass: 'btn-blue',
					action: function() {
						// $.post('/' + isbn, function() {
						// });
						// $.ajax({
						// 	type: "DELETE",
						// 	dataType: "json",
						// 	url: "/" + isbn,
						// 	data: {
						// 		"_token": "{{ csrf_token() }}"
						// 	},
						// 	success: function(data) {
						// 		//data = JSON.parse(data);
								
						// 		$('#stockTable').DataTable().ajax.reload(null, false);
						// 		//console.log(data);
						// 	},
						// 	error: function(data) {
						// 		//data = JSON.parse(data);
						// 		$('#stockTable').DataTable().ajax.reload(null, false);
						// 		//console.log(data);
						// 	}
						// });
						window.location.href = "/" + isbn;
						
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