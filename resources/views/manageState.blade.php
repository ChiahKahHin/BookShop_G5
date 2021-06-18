@extends("layouts.template")

@section('title')
    Admin | Manage State
@endsection

@section('navtitle')
    Manage State
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-10">
                                <span style="font-weight: bold; color: black;">Manage State</span>
                                <p class="text-success">{{ session('message') }}</p>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('addState') }}" style="float:right;" class="btn bg-gradient-primary">Add State</a>
                            </div>
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
                                            State
										</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Delivery Cost (RM)
										</th>
                                        <th class="text-left text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($states as $state)
                                    <tr style="line-height: 3rem;">
                                        <td class="align-middle text-md" style="padding-left: 25px">
											<h6 class="mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $state->state }}</p>
                                        </td>
                                        <td class="align-middle text-left text-sm">
                                            <p class="text-md text-dark font-weight-bold mb-0">{{  $state->delivery_cost }}</p>
                                        </td>
                                        <td class="align-middle text-left">
                                            <a href="{{ route('editState', ['id' => $state->id]) }}">
                                                <i class="material-icons btn-stock-action" style="color: blue">mode_edit</i>
                                            </a>
                                            
                                            <a class="material-icons btn-stock-action deleteState" style="color: blue" id="{{ $state->id }}" value="{{ $state->state }}">delete</a>
                                            
                                        </td>
                                    </tr>
										@endforeach
                                        @if (count($states) == 0)
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
        $(document).on('click', '.deleteState', function() {
		    var stateID = $(this).attr('id');
		    var stateName = $(this).attr('value');
            Swal.fire({
                title: 'Delete State?',
                text: 'State Name: ' + stateName,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#F00',
                confirmButtonColor: '#00F',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Deleted state with the name: " + stateName,
                        icon: 'success',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function() {
                        window.location.href = "/manageState/" + stateID;
                    });
                }
		    });
        });
    </script>
@endsection