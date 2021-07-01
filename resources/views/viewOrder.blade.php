@extends("layouts.template")

@section('title')
    Admin | View Order 
@endsection

@section('navtitle')
    View Order 
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-10">
                                <span style="font-weight: bold; color: black;">View Order</span>
                                <p class="text-success">{{ session('message') }}</p>
                            </div>
                        <!--
                            <div class="col-2">
                                <a href="{{ route('addAdmin') }}" style="float:right;" class="btn bg-gradient-primary">Add Admin</a>
                            </div>
                        -->
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
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Customer
										</th>
                                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7 ps-2">
                                            No. Book
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Total Price
										</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Order Checkout Date 
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Order Received Date 
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Status
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            View
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($checkouts as $checkout)
                                    <tr>
                                        <td class="align-middle text-md" style="padding-left: 25px">
											<h6 class="mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->user->username }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->items->count() }}</p>                                    
                                        </td>
                                        <td class="align-middle text-left text-sm">
                                            <p class="text-md text-dark font-weight-bold mb-0">RM{{ number_format($checkout->total_price, 2) }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  date_format($checkout->created_at,"d F Y") }}</p>                                    
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  ($checkout->status == "delivering") ? "-" : date_format($checkout->updated_at,"d F Y") }}</p>                                    
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{ ucfirst($checkout->status) }}</p>                                    
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="/viewOrderHistory/{{ $checkout->checkoutID }}" class="btn bg-gradient-info mt-2">
                                                View
                                            </a>
                                        </td>
                                    </tr>
									@endforeach
                                        @if (count($checkouts) == 0)
                                            <tr>
                                                <td colspan="10" style="text-align: center;">No data available in table</td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection