@extends("layouts.template")

@section('title')
    Admin | Manage Order 
@endsection

@section('navtitle')
    Manage Order 
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-10">
                                <span style="font-weight: bold; color: black;">Manage Order</span>
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
                                            User ID
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Total Price (RM)
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Address
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
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->user_id }}</p>
                                        </td>
                                        <td class="align-middle text-left text-sm">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->total_price }}</p>
                                        </td>
                                        <td class="align-middle text-left">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->address }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $checkout->status }}</p>                                    
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="" class="btn bg-gradient-info mt-2">
                                                View
                                            </a>
                                        </td>
                                    </tr>
										@endforeach
                                        @if (count($checkouts) == 0)
                                            <tr>
                                                <td colspan="6" style="text-align: center;">No data available in table</td>
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

@section('script')
    <script>
        $(document).on('click', '.deleteAdmin', function() {
		    var adminID = $(this).attr('id');
		    var adminUsername = $(this).attr('value');
            Swal.fire({
                title: 'Delete Admin?',
                text: 'Username: ' + adminUsername,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#F00',
                confirmButtonColor: '#00F',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Deleted admin with username: " + adminUsername,
                        icon: 'success',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/manageAdmin/" + adminID;
                    });
                }
		    });
        });
    </script>
@endsection