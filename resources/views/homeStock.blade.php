@foreach($stock as $stock)
    <div class="col-3" style="margin-bottom: 20px;">
        <div class="card" id="{{ 'homeBook' . $stock->book_isbn_no }}">
            <div class="card-body text-center" style="padding: 1rem;">

                <img style="height: 350px; width:100%;" class="img-fluid" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                <br><br>
                <div>
                <h6><a href="/home/stock/{{ $stock->book_isbn_no }}">{{ $stock->book_name }}</a></h6>
                    <label>{{ $stock->book_author }}</label>
                    <h6>RM{{ number_format($stock->book_retail_price, 2) }}</h6>
                </div>
                <br>
                
            </div>
        </div>
    </div>
@endforeach
