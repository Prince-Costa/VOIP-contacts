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

            <h3 class="mb-5">Domains</h3>

            <div class="card p-3 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Domain Name">
                        </div>
                    </div>
{{--     
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select border border-primary" required>
                                <option value="">Select Type</option>
                                @foreach($domainTypes as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>    
                                @endforeach                             
                            </select>
                        </div>
                    </div> --}}
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select border border-primary">
                                <option value="">Select Status</option>
                                @foreach($domainStatuses as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>    
                                @endforeach 
                            </select>                      
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" id="filter" class="btn btn-info text-white">Filter</button>
                    <button type="submit"  id="reset"  class="btn btn-primary">Reset</button>
                </div>
            </div>
   

            <div class="table-responsive">
                <table class="table table-striped" id="domainsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function domains () {
            $('#domainsTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                
                ajax: {
                    url:"{{ route('public_free_domain') }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.type = $('#type').val();
                        d.status = $('#status').val();
                    },
                },
                
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
        }

        $(document).ready(function() {
            domains();
        
            $('#filter').click(function() {
                $('#domainsTable').DataTable().destroy();
                domains();
            });

            $('#reset').click(function() {
                $('#name').val('');
                $('#type').val('');
                $('#status').val('');
                $('#domainsTable').DataTable().destroy();
                domains();
            });

            $('#name').on('keyup', function() {
                $('#domainsTable').DataTable().search(this.value).draw();
            });

            // $('#type').on('change', function() {
            //     $('#domainsTable').DataTable().search(this.value).draw();
            // });

            $('#status').on('change', function() {
                $('#domainsTable').DataTable().search(this.value).draw();
            });
        });
        
        
    </script>
    
@endpush