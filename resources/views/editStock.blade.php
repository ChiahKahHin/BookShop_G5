@extends("layouts.template")

@section('title')
    Admin | Edit Stock
@endsection

@section('navtitle')
    Edit Stock
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Stock</h6>
                        <p class="text-success">{{ session('message') }}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('editStock', ["isbn" => $stock->book_isbn_no]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Book Name</label>
                                        <input type="text" name="book_name" id="book_name" class="form-control @error('book_name') border-danger @enderror" placeholder="e.g. The Devil’s Woods" value="{{ old('book_name', $stock->book_name) }}">
                                        @error('book_name')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Book Author</label>
                                        <input type="text" name="book_author" id="book_author" class="form-control @error('book_author') border-danger @enderror" placeholder="e.g. Neal Stephenson" value="{{ old('book_author', $stock->book_author) }}">
                                        @error('book_author')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Book Publication Date</label>
                                        <input type="date" name="book_publication_date" id="book_publication_date" class="form-control @error('book_publication_date') border-danger @enderror" value="{{ old('book_publication_date', $stock->book_publication_date) }}">
                                        @error('book_publication_date')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Book ISBN No.</label>
                                        <input type="text" name="book_isbn_no" id="book_isbn_no" class="form-control" value="{{ $stock->book_isbn_no }}" disabled="disabled">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Book Description</label>
                                        <textarea type="text" name="book_description" id="book_description" class="form-control @error('book_description') border-danger @enderror" placeholder="Description of the book" rows="6" style="min-height:10rem;" maxlength="65535" onkeyup="countWords(this)">{{ old('book_description', $stock->book_description) }}</textarea>
                                        <div id="description_word_count" class="text-sm" style="text-align: right">
                                            0/65535
                                        </div>
                                        @error('book_description')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Book Front Cover <i>(Only images with .pdf, .jpg, .png, .jpeg extension can be accepted) (Optional)</i></label>
                                        <input type="file" name="book_front_cover" id="book_front_cover" class="form-control @error('book_front_cover') border-danger @enderror" accept=".pdf,.jpg,.png,.jpeg">
                                        @error('book_front_cover')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <img style="width:25%;" id="img-modal" class="img-thumbnail" alt="{{ $stock->book_name }}" src="data:image/png;base64,{{ chunk_split(base64_encode($stock->book_front_cover)) }}">
                                        <div id="image-modal" class="img-modal">
                                            <span class="close">&times;</span>
                                            <img class="img-modal-content" id="img-block-preview">
                                            <div id="caption"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label>Book Trade Price <i>(RM)</i></label>
                                        <input type="range" name="book_trade_price_range" id="book_trade_price_range" class="form-range @error('book_trade_price_input') border-danger @enderror" value="{{ old('book_trade_price_input', $stock->book_trade_price) }}" min="0" max="500" step=".5" oninput="document.getElementById('book_trade_price_input').value = this.value">
                                        @error('book_trade_price_input')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <input type="number" style="text-align: center;" name="book_trade_price_input" id="book_trade_price_input" class="form-control" value="{{ old('book_trade_price_input', $stock->book_trade_price) }}" min="0" max="500" step=".5" oninput="document.getElementById('book_trade_price_range').value = this.value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label>Book Retail Price <i>(RM)</i></label>
                                        <input type="range" name="book_retail_price_range" id="book_retail_price_range" class="form-range @error('book_retail_price_input') border-danger @enderror" value="{{ old('book_retail_price_input', $stock->book_retail_price) }}" min="0" max="500" step=".5" oninput="document.getElementById('book_retail_price_input').value = this.value">
                                        @error('book_retail_price_input')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <input type="number" style="text-align: center;" name="book_retail_price_input" id="book_retail_price_input" class="form-control" value="{{ old('book_retail_price_input', $stock->book_retail_price) }}" min="0" max="500" step=".5" oninput="document.getElementById('book_retail_price_range').value = this.value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <label>Book Quantity</label>
                                        <input type="range" class="form-range @error('book_quantity_input') border-danger @enderror" name="book_quantity_range" id="book_quantity_range" value="{{ old('book_quantity_input', $stock->book_quantity) }}" min="1" max="20" oninput="document.getElementById('book_quantity_input').value = this.value">
                                        @error('book_quantity_input')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <input type="number" style="text-align: center;" class="form-control" name="book_quantity_input" id="book_quantity_input" value="{{ old('book_quantity_input', $stock->book_quantity) }}" oninput="document.getElementById('book_quantity_range').value = this.value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Update Stock</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="http://code.jquery.com/jquery-1.5.js"></script>
@section('script')
    <script>
        function countWords(words){
            var maxlength = document.getElementById('book_description').maxLength;
            $('#description_word_count').text(words.value.length + "/" + maxlength);
        };

        // Get the modal
        var modal = document.getElementById("image-modal");
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("img-modal");
        var modalImg = document.getElementById("img-block-preview");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
        </script>
@endsection
