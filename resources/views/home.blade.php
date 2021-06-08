@extends("layouts.template")

@section("title")
Home
@endsection

@section('navtitle')
<img src="../assets/img/book-icon.png" class="navbar-brand-img h-100 w-15" alt="...">
Book Shop
@endsection

@section("carouselSlides")
{{-- Carousel Caption --}}
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ URL::asset('assets/img/book_bg.jpg') }}" class="d-block w-100" alt="..." style="max-height: 35rem;">
        <div class="carousel-caption d-none d-md-block">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ URL::asset('assets/img/book_bg1.jpg') }}" class="d-block w-100" alt="..." style="max-height: 35rem;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{ URL::asset('assets/img/book_bg2.jpg') }}" class="d-block w-100" alt="..." style="max-height: 35rem;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
{{-- Carousel Caption End --}}
@endsection

@section("content")
<div class="container py-4">

    <div class="" style="margin-bottom: 30px;">
        <form action="{{ route('homeSearch') }}" method="post">
            <input type="search" class="form-control" name="homeSearch" id="homeSearchInput" placeholder="Search for books...">
        </form>

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