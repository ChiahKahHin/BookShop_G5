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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <p class="text-md text-dark font-weight-bold mb-0 px-2">Order ID # {{ $checkout->checkoutID }}</p>
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
                                <p class="text-md text-dark font-weight-bold mb-0 px-2">Order Checkout Date & Time</p>
                                <p class="text-md text-dark mb-0 px-2">{{ date_format($checkout->created_at,"d F Y g:ia") }}</p>
                            </div>
                        </div>
                        @if ($checkout->status == "delivered")
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">Order Received Date & Time</p>
                                    <p class="text-md text-dark mb-0 px-2">{{ date_format($checkout->updated_at,"d F Y g:ia") }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <p class="text-md text-dark font-weight-bold mb-0 px-2">Order Status</p>
                                <p class="text-md text-dark mb-0 px-2">{{ ucfirst($checkout->status) }}</p>
                            </div>
                        </div>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach ($checkout->items as $checkoutItems)
                            @php
                                $subtotal += $checkoutItems->books->book_retail_price*$checkoutItems->book_quantity;
                            @endphp
                        @endforeach
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <p class="text-md text-dark font-weight-bold mb-0 px-2">Delivery Cost</p>
                                <p class="text-md text-dark mb-0 px-2">RM{{ number_format($checkout->total_price - $subtotal, 2) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <p class="text-md text-dark font-weight-bold mb-0 px-2">Total Price <i>(included delivery cost)</i></p>
                                <p class="text-md text-dark mb-0 px-2">RM{{ number_format($checkout->total_price, 2) }}</p>
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
                                                Book ISBN No.
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                Book Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                Unit Price
                                            </th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                                Book Quantity
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
                                                <p class="text-md text-dark font-weight-bold mb-0">{{ $checkoutItems->book_isbn_no }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-md text-dark font-weight-bold mb-0">{{ $checkoutItems->books->book_name }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-md text-dark font-weight-bold mb-0">RM{{ number_format($checkoutItems->books->book_retail_price, 2) }}</p>
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
                    @if ($checkout->status == "delivering")
                        <button type="button" id="orderReceive" class="btn bg-gradient-info mb-0 form-control">Order Receive</button>
                    @endif
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection





@section("script")
<script>
    $('#orderReceive').on('click', function(){
        Swal.fire({
            title: 'Are you sure you receive the orders?',
            icon: 'warning',
            icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#F00',
			confirmButtonColor: '#00F',
			confirmButtonText: 'Yes'
        }).then((result) => {
			if (result.value) {
                $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: "{{ route('orderReceive') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "checkoutID": "{{ $checkout->checkoutID }}"
                    },
                    success: function(data) {
                        if(data == "success"){
                            Swal.fire({
                                title: 'Order Received',
                                text: "",
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function (){
                                window.location.reload();
                            });
                        }
                    }
                });
            }
		});
    });
</script>
@endsection