@foreach ($stock as $stock)
    <div class="col-3" style="margin-bottom: 20px;">
        <div class="card" id="{{ 'homeBook' . $stock->book_isbn_no }}">
            <div class="card-body text-center" style="padding: 0.85rem;">

                <img style="height: 350px; width:100%;" class="img-fluid"
                    src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                <div style="height: 0.75rem;"></div>
                <div>
                    <h6 class="m-0">
                        <a href="{{ route('stockDetails', ['isbn' => $stock->book_isbn_no]) }}">{{ $stock->book_name }}</a>
                    </h6>
                    <label class="ms-0" style="margin-left: 0;">{{ $stock->book_author }}</label>
                    <h6>RM {{ number_format($stock->book_retail_price, 2) }}</h6>
                    @auth
                        <div class="input-group justify-content-center">
                            <input type="button" value="-" class="button-minus" data-field="quantity">
                            <input type="number" step="1" max="20" value="1" name="quantity" class="quantity-field"
                                id="{{ 'bookQty' . $stock->book_isbn_no }}">
                            <input type="button" value="+" class="button-plus" data-field="quantity">
                        </div>
                        <button type="button" class="btn bg-gradient-info mb-0 addBookToCart"
                            data-bookName="{{ $stock->book_name }}" value="{{ $stock->book_isbn_no }}"><i
                                class="fa fa-shopping-cart"></i> Add to Cart</button>
                    @endauth
                </div>

            </div>
        </div>
    </div>
@endforeach

<script>
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
                if (data) {
                    Swal.fire({
                        title: 'Book Added',
                        text: bookName,
                        icon: 'success',
                        type: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            }
        });
    });

</script>

<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
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
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
    });

</script>
