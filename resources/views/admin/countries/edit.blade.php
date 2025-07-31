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
        <div class="col-lg-12">
            <h3 class="mb-5">Update Country</h3>
            <form action="{{ route('countries.update', $country->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Country Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control border border-primary" id="name" name="name" value="{{ old('name', $country->name) }}" placeholder="Enter country name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="iso_code" class="form-label">ISO Code<span class="text-danger">*</span></label>
                            <input type="text" class="form-control border border-primary" id="iso_code" name="iso_code" value="{{ old('iso_code', $country->iso_code) }}" placeholder="Enter ISO code">
                        </div>                     
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="country_code" class="form-label">Country Code</label>
                            <input type="text" class="form-control border border-primary" id="country_code" name="country_code" value="{{ old('country_code', $country->country_code) }}" placeholder="Enter country code">
                        </div> 
                        <div class="form-group mb-3">
                            <label for="world_region" class="form-label">World Region</label>
                            <select class="form-select border border-primary" id="world_region" name="world_region">
                                <option value="" selected disabled>Select world region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->name}}">{{ $region->name }}</option>   
                                @endforeach
                            </select>
                            @error('world_region')
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
