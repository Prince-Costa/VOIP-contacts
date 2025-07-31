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

            <h3 class="mb-5">Logs</h3>

            <div class="table-responsive">
                <table class="table table-striped" id="logTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width:250px;">Description</th>                      
                            <th style="min-width:250px;">User</th>
                            <th>Time</th>
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
            $('#logTable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 25,
            ajax: {
                url: "{{ route('logs.index') }}",
                type: "GET",                   
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'description', name: 'description' },
                { data: 'user', name: 'user' },                  
                // { data: 'action', name: 'action', orderable: false, searchable: false }
                { data: 'created_at', name: 'created_at' }
            ]
            });
        });
    </script>    
@endpush