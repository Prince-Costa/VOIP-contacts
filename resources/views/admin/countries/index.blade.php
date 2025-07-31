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
        <div class="col-lg-12 mb-3">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed text-white fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add Country
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('countries.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Country Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border border-primary" id="name" name="name" placeholder="Enter country name" required>

                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iso_code" class="form-label">ISO Code<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border border-primary" id="iso_code" name="iso_code" placeholder="Enter ISO code">
                                        @error('iso_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>                     
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_code" class="form-label">Country Code</label>
                                        <input type="text" class="form-control border border-primary" id="country_code" name="country_code" placeholder="Enter country code">
                                        @error('country_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                  </div>
                </div>
            </div>  
        </div>
        <div class="col-lg-12 mt-5">
            <h3 class="mb-5">Countries</h3>

            <table class="table table-striped" id="countriesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Country Code</th>
                        <th>ISO Code</th>
                        <th>World Region</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $country->name }}</td>
                            <td>{{$country->country_code}}</td>
                            <td>{{$country->iso_code}}</td>
                            <td>{{$country->world_region}}</td>
                            <td>
                                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#countriesTable').DataTable({
            "pageLength": 25,
            });
        });

    </script>
@endpush