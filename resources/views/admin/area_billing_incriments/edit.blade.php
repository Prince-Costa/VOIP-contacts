@extends('admin.layout.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mx-0 mt-3">
        <div class="col-md-12">
            <h3 class="mb-5">Edit Area Billing Increments</h3>

            <form action="{{ route('area_billing_incriments.update', $areaBillingIncrement->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="destination_name" class="form-label">Destination Name<span class="text-primary">*</span></label>
                            <input type="text" name="destination_name" id="destination_name" class="form-control border border-primary" required placeholder="Enter Area Destination Name" value="{{ old('destination_name', $areaBillingIncrement->destination_name) }}">
                            @error('destination_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="breakouts" class="form-label">Breakouts<span style="font-size:12px;">(unique)</span><span class="text-primary">*</span></label>
                            <input type="text" name="breakouts" id="breakouts" class="form-control border border-primary" placeholder="Enter Breakouts Code (Telecom)" value="{{ old('breakouts', $areaBillingIncrement->breakouts) }}" required>
                            @error('breakouts')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="billing_incriment" class="form-label">Billing Increment<span class="text-primary">*</span></label>
                            <input type="text" name="billing_incriment" id="billing_incriment" class="form-control border border-primary" required placeholder="Enter Billing Increment" value="{{ old('billing_incriment', $areaBillingIncrement->billing_incriment) }}">
                            @error('billing_incriment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="refer" class="form-label">Refer</label>
                            <input type="text" name="refer" id="refer" class="form-control border border-primary" placeholder="Enter References" value="{{ old('refer', $areaBillingIncrement->refer) }}">
                            @error('refer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>                   
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>       
    </div>
@endsection
