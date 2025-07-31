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

            <h3 class="mb-5">Area Biling Increments</h3>

            <div class="table-responsive">
                <table class="table table-striped" id="area_billing">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width:250px;">Country Name</th>                      
                            <th style="min-width:150px;">Breakouts</th>
                            <th style="min-width:250px;">Billing Incriments</th>
                            <th style="min-width:250px;">Rafer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>        
</div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#area_billing').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                ajax: "{{ route('area_billing_incriments.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'destination_name', name: 'destination_name' },
                    { data: 'breakouts', name: 'breakouts' },
                    { data: 'billing_incriment', name: 'billing_incriment' },
                    { data: 'refer', name: 'refer' },   
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>    
@endpush