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
            <h3 class="mb-5">Update Domain</h3>

            <form action="{{ route('domains.update',$domain->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="{{$domain->name}}" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Domain Name">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select border border-primary" required>
                                <option value="">Select Type</option>
                                @foreach ($domainTypes as $domainType)
                                    <option value="{{ $domainType->name }}" {{$domain->type == $domainType->name ? 'selected' : ''}}>{{ $domainType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select border border-primary">
                                <option value="">Select Status</option>
                                @foreach ($domainStatuses as $status)
                                    <option value="{{ $status->name }}" {{ $domain->status == $status->name ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>       
    </div>
@endsection