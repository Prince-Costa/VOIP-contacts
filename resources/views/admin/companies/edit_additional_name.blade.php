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
        <div class="col-md-12 px-5">
            <h3 class="mb-5">Edit Companies Additional Name</h3>

            <form action="{{ route('additional_companies.update', $additionalName->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')

                <div class="row">
                    <p>Company Name: {{$additionalName->company->name}}</p>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="mb-3 text-dark" for="name" class="form-label">Name</label>
                            <input type="text" class="form-control border border-primary" id="name" name="name" value="{{$additionalName->name}}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

               <div class="d-flex">
                <a href="{{ route('additional_companies.index') }}" class="btn btn-info me-2 text-white">Go To Additional Names</a>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancle</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>       
    </div>
@endsection

@push('scripts')
    <script>
       
    </script>
@endpush