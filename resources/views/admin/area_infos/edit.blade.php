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
            <h3 class="mb-5">Edit Area Information</h3>

            <form action="{{ route('area_infos.update', $areaInfo->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span class="text-primary">*</span></label>
                            <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter area Name" value="{{ old('name', $areaInfo->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="prefix" class="form-label">Prefix<span style="font-size:12px;">(unique)</span><span class="text-primary">*</span></label>
                            <input type="text" name="prefix" id="prefix" class="form-control border border-primary" placeholder="Enter Area Prefix" value="{{ old('prefix', $areaInfo->prefix) }}" required>
                            @error('prefix')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="iso_code" class="form-label">Iso Code<span class="text-primary">*</span></label>
                            <input type="text" name="iso_code" id="iso_code" class="form-control border border-primary" required placeholder="Enter area iso code" value="{{ old('iso_code', $areaInfo->iso_code) }}">
                            @error('iso_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="billing_increments" class="form-label">Billing Increments</label>
                            <input type="text" name="billing_increments" id="billing_increments" class="form-control border border-primary" placeholder="Enter billing increments" value="{{ old('billing_increments', $areaInfo->billing_increments) }}">
                            @error('billing_increments')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="remarks1" class="form-label">Remarks1</label>
                        <textarea type="text" name="remarks1" id="remarks1" class="form-control border border-primary" placeholder="Add note">{{ old('remarks1', $areaInfo->remarks1) }}</textarea>
                        @error('remarks1')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="remarks2" class="form-label">Remarks2</label>
                        <textarea type="text" name="remarks2" id="remarks2" class="form-control border border-primary" placeholder="Add note">{{ old('remarks2', $areaInfo->remarks2) }}</textarea>
                        @error('remarks2')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>       
    </div>
@endsection
