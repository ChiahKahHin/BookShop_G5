@extends("layouts.template")

@section('title')
    Admin | View Order History Details
@endsection

@section('navtitle')
View Order History Details
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <u><h6>Customer Order Checkout Details</h6></u>
                    </div>
                    <div class="card-body">
                    <h6 class="pb-3">Order ID # {{$checkouts->checkoutID}}</h6>

                    <h6>Customer</h6>
                    <p>{{ $checkouts->user->username}}</p>

                    <h6>Phone No.</h6>
                    <p>{{ $checkouts->user->phone}}</p>
                    
                    <h6>Customer Address</h6>
                    <p>{{ $checkouts->address}}</p>

                    <h6>Order Date & Time</h6>
                    <p>{{ date_format($checkouts->created_at,"d F Y g:ia") }}</p>
                    
                    @if ($checkouts->status != "delivering")
                    <h6>Order Received Date & Time</h6>
                    <p>{{ date_format($checkouts->updated_at, "d F Y g:ia") }}</p>
                    @endif
                       
                    <h6>Order Status</h6>
                    <p>{{ ucfirst($checkouts->status) }}</p>
                    
                    <h6>Total Order Price</h6>
                    <p>RM{{ number_format($checkouts->total_price, 2) }}</p>
                    </div>

                    <div class="card-header pb-0">
                        <u><h6>Order Items Checkout Details</h6></u>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px">
                                            No.
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2, align-middle text-center">
                                            Book ISBN No.
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2, align-middle text-center">
                                            Book Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2, align-middle text-center">
                                            Book Quantity
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2, align-middle text-center">
                                            Total Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($checkouts->items as $checkoutItem)
                                    <tr>
                                        <td class="align-middle text-md" style="padding-left: 25px">
                                            <h6 class="mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a class="text-md font-weight-bold mb-0" style="text-decoration: underline; color:blue" href="{{ route("stockDetails", ["isbn" => $checkoutItem->book_isbn_no]) }}">{{  $checkoutItem->book_isbn_no }}</a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkoutItem->books->book_name }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkoutItem->book_quantity }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">RM{{  number_format($checkoutItem->books->book_retail_price*$checkoutItem->book_quantity, 2) }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end" style="margin-top: 10px; margin-bottom: 10px; padding-right: 30px">
                            <a href="{{ route('viewOrder') }}" class="btn bg-gradient-info mb-0">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection