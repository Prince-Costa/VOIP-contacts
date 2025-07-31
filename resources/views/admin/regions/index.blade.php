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
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed text-white fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add World Region
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('regions.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Region Name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>   
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" name="code" id="code" class="form-control border border-primary" required placeholder="Enter Region Code" value="{{ old('code') }}">
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>   
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">

            <div class="rounded h-100 p-2">
                <h3 class="mb-5">World Regions</h3>
                <div class="table-responsive">
                    <table class="table table-striped" id="regionTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($regions as $region)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $region->name }}                               
                                    </td>
                                    <td>
                                        {{ $region->code }}                               
                                    </td>
                                    <td>
                                        <a href="{{ route('regions.edit', $region->id) }}" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('regions.destroy', $region->id) }}" method="POST" style="display:inline;"  onsubmit="return confirm('Are you sure you want to delete this region?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#regionTable').DataTable(
                {
                    "pageLength": 25,
                }
            );
        });
    </script>
    
@endpush