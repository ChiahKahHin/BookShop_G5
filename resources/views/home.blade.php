@extends("layouts.template")

@section("title")
Home
@endsection

@section('navtitle')
Book Shop
@endsection

@section("content")
<div class="container py-4">
    <div class="" style="margin-bottom: 30px;">
        <!-- <form action="{{ route('homeSearch') }}" method="post">
            <input type="search" class="form-control" name="homeSearch" id="homeSearchInput" placeholder="Search for books...">
        </form> -->

    </div>

    <div class="row" id="homeStockRow">

    @include('homeStock')
    
    </div>

</div>
@endsection

@section("script")
<script>
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    $('#homeSearchInput').on('input', function(){
        var searchKeyword = this.value;
        $.ajax({
			type: "POST",
            dataType: "text",
			url: "{{ route('homeSearch') }}",
			data: {
                "homeSearch": searchKeyword,
                "_token": "{{ csrf_token() }}"
			},
			success: function(data) {
                console.log(searchKeyword);
                $('#homeStockRow').html(data);
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