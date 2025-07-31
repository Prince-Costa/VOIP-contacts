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
        <div class="col-md-12 mb-3">
            <a href="{{ route('area_infos.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="col-md-12">
            <h3 class="mb-5">Area Information</h3>

            <div class="card p-3 mb-5">
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>{{ $areaInfo->name }}</td>
                </tr>
                <tr>
                    <th>Prefix</th>
                    <td>{{ $areaInfo->prefix }}</td>
                </tr>
                <tr>
                    <th>ISO Code</th>
                    <td>{{ $areaInfo->iso_code }}</td>
                </tr>
                <tr>
                    <th>Remarks1</th>
                    <td>{{ $areaInfo->remarks1 }}</td>
                </tr>

                <tr>
                    <th>Remarks2</th>
                    <td>{{ $areaInfo->remarks2 }}</td>
                </tr>
            </table>
            </div>
        </div>
    </div>                

                     
</div>


@endsection