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
                        @if($stock->book_quantity <= 0)
                            <div class="input-group justify-content-center">
                                <input type="button" value="-" class="button-minus" data-field="quantity" disabled>
                                <input type="number" step="1" max="{{ $stock->book_quantity }}" value="1" name="quantity" class="quantity-field validateEmpty"
                                    id="{{ 'bookQty' . $stock->book_isbn_no }}" disabled>
                                <input type="button" value="+" class="button-plus" data-field="quantity" data-maxQty="{{ $stock->book_quantity }}" disabled>
                            </div>
                            <button type="button" class="btn bg-gradient-info mb-0" disabled><i class="fa fa-shopping-cart"></i> Out of Stock</button>
                        @else
                            <div class="input-group justify-content-center">
                                <input type="button" value="-" class="button-minus" data-field="quantity">
                                <input type="number" step="1" max="{{ $stock->book_quantity }}" value="1" name="quantity" class="quantity-field validateEmpty"
                                    id="{{ 'bookQty' . $stock->book_isbn_no }}">
                                <input type="button" value="+" class="button-plus" data-field="quantity" data-maxQty="{{ $stock->book_quantity }}">
                            </div>
                            <button type="button" class="btn bg-gradient-info mb-0 addBookToCart"
                                data-bookName="{{ $stock->book_name }}" value="{{ $stock->book_isbn_no }}"><i
                                    class="fa fa-shopping-cart"></i> Add to Cart</button>
                        @endif
                    @endauth
                </div>

            </div>
        </div>
    </div>
@endforeach

<script>
    $(document).ready(function (){
        $(document).on('change', '.validateEmpty', function(){
            var qtyInput = this.value;

            if(qtyInput == "" || qtyInput == null){
                this.value = 1;
            }
        });

        var allQtyInput = document.getElementsByClassName('quantity-field');
        
        for(var i=0; i < allQtyInput.length; i++){  
            allQtyInput[i].oninput = function(){
                var max = parseInt(this.max);
                if (parseInt(this.value) > max) {
                    this.value = max; 
                }
                else if(parseInt(this.value) == 0){
                    this.value = 1;
                }
            }
        }
    });
    
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
                    });
                }
                else if(data == "sameAmount"){
                    Swal.fire({
                        title: 'Failed to Add',
                        html: bookName + "<br>" + "Quantity added to cart is at maximum!",
                        icon: 'error',
                        timer: 3500,
                        showConfirmButton: false
                    });
                }
                else{
                    Swal.fire({
                        title: 'Some Book Added',
                        html: bookName + "<br>Maximum Quantity Reached!<br>Only " + data + " book(s) added",
                        icon: 'error',
                        timer: 3500,
                        showConfirmButton: false
                    });
                }
            }
        });
    });

</script>

<script>
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

</script>
