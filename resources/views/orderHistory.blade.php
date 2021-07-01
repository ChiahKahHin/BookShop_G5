@extends("layouts.template")

@section('title')
    Order History
@endsection

@section('navtitle')
    Order History
@endsection

@section('content')
    <div class="text-center"><h3 class="mb-0">Order History</h3></div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-8 m-auto">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-10">
                                <p class="text-success">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7 ps-2" width="100px">
                                            Order ID
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Order date
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Total price (RM)
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Status
										</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            View
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($checkout as $receipt)
                                    <tr>
                                        <td>
                                            <p class="text-md text-dark text-center font-weight-bold mb-0">{{  $receipt->checkoutID }}</p>
                                        </td>
                                        <td class="align-middle text-left">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  date_format($receipt->created_at,"d F Y") }}</p>
                                        </td>
                                        <td class="align-middle text-left text-sm">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{ number_format($receipt->total_price, 2) }}</p>
                                        </td>
                                        <td class="align-middle text-left">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  ucfirst($receipt->status) }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="/orderInformation/{{ $receipt->checkoutID }}" class="btn bg-gradient-info mt-2">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if (count($checkout) == 0)
                                        <tr>
                                            <td colspan="10" style="text-align: center;">No order history found!</td>
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
@endsection