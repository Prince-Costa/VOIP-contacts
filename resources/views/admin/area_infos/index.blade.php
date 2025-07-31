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

            <h3 class="mb-5">Area Informations</h3>

            <div class="card p-3 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="prefix" class="form-label">Prefix</label>
                            <input type="text" name="prefix" id="prefix" class="form-control border border-primary" required placeholder="Enter Prefix">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Name">
                        </div>
                    </div>
    
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label for="iso_code" class="form-label">ISO Code</label>
                            <input type="text" name="iso_code" id="iso_code" class="form-control border border-primary" required placeholder="Enter ISO Code">
                        </div>
                    </div> --}}
                </div>

                <div class="text-end">
                    <button type="submit" id="filter" class="btn btn-info text-white">Filter</button>
                    <button type="submit" id="reset"  class="btn btn-primary">Reset</button>
                </div>
            </div>

            <div class="table-responsive">
                <div class="mb-3">   
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Area Informations(Excel or CSV)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('area_infos.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Choose File</label>
                                            <input type="file" name="file" id="file" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-info text-white">Import</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#importModal">
                        Import
                    </button>

                    <a href="{{route('area_infos.export')}}" id="export" class="btn btn-success">Export</a>
           

                    <button type="button" id="batch_delete" class="btn btn-danger">Batch Delete</button>
                </div>
                <table class="table table-striped" id="area_infosTable">
                    <thead>
                        <tr>
                            <th style="">
                                <input type="checkbox" class="form-check-input" id="select_all">    
                            </th>
                            <th>#</th>
                            <th style="min-width:150px;">Prefix</th>
                            <th style="min-width:250px;">Name</th>                      
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
        function areaInfos () {
            $('#area_infosTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                ajax: {
                    url: "{{ route('area_infos.index') }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.prefix = $('#prefix').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, render: function(data, type, row) {
                        return `<input type="checkbox" class="form-check-input ms-2" value="${row.id}">`;
                    } },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'prefix', name: 'prefix' },
                    { data: 'name', name: 'name' },             
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        };

        $(document).ready(function() {
            areaInfos();

            $('#filter').click(function() {
                $('#area_infosTable').DataTable().destroy();
                areaInfos();
            });

            $('#reset').click(function() {
                $('#name').val('');
                $('#prefix').val('');
                $('#area_infosTable').DataTable().destroy();
                areaInfos();
            });

            $('#name').on('keyup', function() {
                $('#area_infosTable').DataTable().search(this.value).draw();
            });

            $('#prefix').on('keyup', function() {
                $('#area_infosTable').DataTable().search(this.value).draw();
            });

        });
       
        $('#select_all').click(function() {
            let isChecked = $(this).is(':checked');
            $('#area_infosTable tbody input[type="checkbox"]').prop('checked', isChecked);
        });

        $('#batch_delete').click(function() {
            let selectedIds = [];
            $('#area_infosTable tbody input[type="checkbox"]:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Please select at least one record to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete the selected records?')) {
                $.ajax({
                    url: "{{ route('area_infos.batch_delete') }}",
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#area_infosTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the records.');
                    }
                });
            }
        });
    </script>    
@endpush