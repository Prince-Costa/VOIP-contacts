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

            <h3 class="mb-5">Companies</h3>

            <div class="card p-3 mb-5">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control border border-primary" placeholder="Enter Company Name" value="{{ old('name') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="domain_id" class="form-label">Domain</label>
                        <select name="domain_id" id="domain_id" class="form-select border border-primary">

                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="based_on" class="form-label">Origin Country</label>
                        <select name="based_on" id="based_on" class="form-select border border-primary">
                            <option value="">Select Origin Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="interconnection_type" class="form-label">Interconnection Status with Company</label>
                        <select name="interconnection_type" id="interconnection_type" class="form-select border border-primary">
                            <option value="">Select Interconnection Status</option>
                            @foreach($interconnectionTypes as $interconnectionType)
                                <option value="{{ $interconnectionType->id }}">{{ $interconnectionType->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="tag_id" class="form-label">Tags</label>
                        <select name="tag_id" id="tag_id" class="form-select border border-primary">
                            <option value="">Select Tag</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="text-end">
                    <button type="submit" id="filter" class="btn btn-info text-white">Filter</button>
                    <button type="submit" id="reset" class="btn btn-primary">Reset</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="companiesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width:250px;">Name</th>                      
                            <th style="min-width:500px;">Others</th>
                            <th style="min-width:250px;">Country</th>
                            <th style="min-width:130px;">Tags</th>
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
        function companies () {
            $('#companiesTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                ajax: {
                    url: "{{ route('companies.index') }}",
                    type: "GET",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.domain_id = $('#domain_id').val();
                        d.based_on = $('#based_on').val();
                        d.interconnection_type = $('#interconnection_type').val();
                        d.tag_id = $('#tag_id').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'others', name: 'others' },
                    { data: 'country', name: 'country' },     
                    { data: 'tags', name: 'tags' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        };

        $(document).ready(function() {
            companies();

            $('#filter').click(function(e) {
                e.preventDefault();
                $('#companiesTable').DataTable().destroy();
                companies();
            });

            $('#reset').click(function(e) {
                e.preventDefault();
                $('#name').val('');
                $('#domain_id').val('').trigger('change');
                $('#based_on').val('').trigger('change');
                $('#interconnection_type').val('').trigger('change');
                $('#tag_id').val('').trigger('change');
                $('#companiesTable').DataTable().destroy();
                companies();
            });

            $('#name').on('keyup', function() {
                $('#companiesTable').DataTable().search(this.value).draw();
            });

            $('#domain_id').on('change', function() {
                $('#companiesTable').DataTable().search(this.value).draw();
            });
            
            $('#interconnection_type').on('change', function() {
                $('#companiesTable').DataTable().search(this.value).draw();
            });

            $('#based_on').on('change', function() {
                $('#companiesTable').DataTable().search(this.value).draw();
            });

            $('#tag_id').on('change', function() {
                $('#companiesTable').DataTable().search(this.value).draw();
            });

            $('#based_on').select2({
                placeholder: "Select Origin Country",
                allowClear: true
            });

            

            $('#domain_id').select2({
                ajax: {
                    url: '{{route('getDomains')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: Object.entries(data).map(([id, text]) => ({
                                id, text
                            }))
                        };
                    },
                    cache: true
                },
                placeholder: 'Select a domain',
                minimumInputLength: 0
            });
        });
    </script>    
@endpush