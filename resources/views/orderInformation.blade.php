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
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Order History Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('orderInformation') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <p class="text-md text-dark mb-0 px-2">Checkout ID</p>
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $checkout->checkoutID }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                <p class="text-md text-dark mb-0 px-2">Total Price</p>
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">RM {{ number_format($checkout->total_price, 2) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                <p class="text-md text-dark mb-0 px-2">Address</p>
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $checkout->address }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                <p class="text-md text-dark mb-0 px-2">Status</p>
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $checkout->status }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                <p class="text-md text-dark mb-0 px-2">Checkout date and time</p>
                                    <p class="text-md text-dark font-weight-bold mb-0 px-2">{{ $checkout->created_at }}</p>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="50px">
                                                    No.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" width="50px">
                                                    Book Name.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" width="50px">
                                                    Book ISBN No.
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2" width="50px">
                                                    Book quantity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checkoutItems as $checkoutItems)
                                            <tr>
                                                <td class="align-middle text-md" style="padding-left: 25px">
                                                    <h6 class="mb-0">{{ $loop->iteration }}</h6>
                                                </td>
                                                <td class="align-middle text-left">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{  $checkoutItems->book_isbn_no }}</p>
                                                </td>
                                                <td class="align-middle text-left">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{  $checkoutItems->book_isbn_no }}</p>
                                                </td>
                                                <td class="align-middle text-left">
                                                    <p class="text-md text-dark font-weight-bold mb-0">{{  $checkoutItems->book_quantity }}</p>
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