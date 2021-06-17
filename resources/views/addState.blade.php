@extends("layouts.template")

@section('title')
    Admin | Add State
@endsection

@section('navtitle')
    Add State
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Add State</h6>
                        <p class="text-success">{{ session('message') }}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('addState') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>State</label>
                                        <select name="state" id="state"
                                            class="form-select @error('state') border-danger @enderror"
                                            aria-label=".form-select example" required>
                                            <option value="" selected>Please select state</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>Delivery Cost (RM)</label>
                                        <input type="number" name="delivery_cost" id="delivery_cost"
                                            class="form-control @error('delivery_cost') border-danger @enderror"
                                            placeholder="e.g. 10" value="{{ old('delivery_cost') }}" required>
                                        @error('delivery_cost')
                                            <div class="text-danger mt-2 text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn bg-gradient-info w-100 mt-4 md-6" type="submit">Add
                                        state</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
