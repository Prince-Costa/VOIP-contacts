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
        <div class="col-lg-5">
            <h3 class="mb-5">Edit Region</h3>

            <form action="{{ route('regions.update', $region->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Region Name" value="{{ old('name', $region->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>   
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control border border-primary" required placeholder="Enter Region Code" value="{{ old('code', $region->code) }}">
                    @error('code')
                        <div class="text-danger">{{ $message }}</div>   
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>        
    </div>
@endsection