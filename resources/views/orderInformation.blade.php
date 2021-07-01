@extends("layouts.template")

@section('title')
    Order History Information
@endsection

@section('navtitle')
    Order History Information
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-10 m-auto">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <u><h6>Order History Information</h6></u>
                </div>
                <div class="card-body">
                    <form action="{{ route('orderInformation', ["checkoutID"=>$checkout->checkoutID]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Order ID</p>
                                    <p class="text-md text-dark mb-0 px-2">{{ $checkout->checkoutID }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Total Price</p>
                                    <p class="text-md text-dark mb-0 px-2">RM{{ number_format($checkout->total_price, 2) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Address</p>
                                    <p class="text-md text-dark mb-0 px-2">{{ $checkout->address }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Status</p>
                                    <p class="text-md text-dark mb-0 px-2">{{ ucfirst($checkout->status) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Order Date & Time</p>
                                    <p class="text-md text-dark mb-4 px-2">{{ date_format($checkout->created_at,"d F Y g:ia") }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <u><p class="text-md text-dark font-weight-bold mb-0 px-2">Order Items Checkout Details</p></u>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0 align-middle text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    No.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Book Name.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Book ISBN No.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Book quantity
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                    Total Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checkout->items as $checkoutItems)
                                            <tr>
                                                <td class="align-middle text-center">
                                                    <h6 class="mb-0">{{ $loop->iteration }}</h6>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{ $checkoutItems->books->book_name }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{ $checkoutItems->book_isbn_no }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{ $checkoutItems->book_quantity }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <p class="text-md text-dark font-weight-bold mb-0">RM{{ number_format($checkoutItems->books->book_retail_price*$checkoutItems->book_quantity, 2) }}</p>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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





@section("script")
<script>
    $(document).on('click', '.tbc', function (){
        
    });
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@endsection