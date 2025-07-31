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
            <h3 class="mb-5">Edit Type</h3>

            <form action="{{ route('interconnections.update', $interconnectionType->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" value="{{$interconnectionType->name}}" id="name" class="form-control border border-primary" required placeholder="Enter Inter Connection Type">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>        
    </div>
@endsection