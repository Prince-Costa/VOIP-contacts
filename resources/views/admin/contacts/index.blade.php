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

            <h3 class="mb-5">Contacts</h3>

            <div class="card p-3 mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Contact Name" value="{{ old('name') }}">
                        </div>
                    </div>    
    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span style="font-size:12px;"></label>
                            <input type="email" name="email" id="email" class="form-control border border-primary" required placeholder="Enter Contact email" value="{{ old('email1') }}">
                        </div>
                    </div>    
    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control border border-primary" required placeholder="Enter Contact phone number" value="{{ old('phone_number') }}">
                        </div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Company<span class="text-primary">*</span></label>
                            <select name="company_id" id="company_id" class="form-select border border-primary">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach                             
                            </select>
                        </div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contact_type_id" class="form-label">Contact Type<span class="text-primary">*</span></label>
                            <select name="contact_type_id" id="contact_type_id" class="form-select border border-primary">
                                <option value="">Select Contact type</option>
                                @foreach($contactTypes as $contactType)
                                    <option value="{{ $contactType->id }}">{{ $contactType->name }}</option>
                                @endforeach                             
                            </select>
                        </div>                  
                    </div>
                </div>
    
                <div class="text-end">
                    <button type="submit" id="filter" class="btn btn-info text-white">Filter</button>
                    <button type="submit" id="reset" class="btn btn-primary">Reset</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="contactsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 150px;">Name</th>
                            <th style="min-width: 300px;">Details</th>
                            <th style="min-width: 200px;">Company</th>
                            <th style="min-width: 200px;">Contact Type</th>
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
        function contacts () {
            $('#contactsTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                pageLength: 25,
                ajax: {
                    url: "{{ route('contacts.index') }}",
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.phone_number = $('#phone_number').val();
                        d.company_id = $('#company_id').val();
                        d.contact_type_id = $('#contact_type_id').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'details', name: 'details' },
                    { data: 'company', name: 'company' },
                    { data: 'contact_type', name: 'contact_type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        };

        $(document).ready(function() {
            contacts();
            $('#filter').click(function() {
                $('#contactsTable').DataTable().destroy();
                contacts();
            });

            $('#reset').click(function() {
                $('#name').val('');
                $('#email').val('');
                $('#phone_number').val('');
                $('#company_id').val('').trigger('change'); // 👈 Trigger change for Select2
                $('#contact_type_id').val('').trigger('change'); // 👈 Trigger change for Select2
                $('#contactsTable').DataTable().destroy();
                contacts();
            });

            $('#name').on('keyup', function() {
                $('#contactsTable').DataTable().search(this.value).draw();
            });

            $('#email').on('keyup', function() {
                $('#contactsTable').DataTable().search(this.value).draw();
            });

            $('#phone_number').on('keyup', function() {
                $('#contactsTable').DataTable().search(this.value).draw();
            });

            $('#company_id').on('change', function() {
                $('#contactsTable').DataTable().search(this.value).draw();
            });

            $('#contact_type_id').on('change', function() {
                $('#contactsTable').DataTable().search(this.value).draw();
            });

            // Initialize Select2 for the company and contact type dropdowns

            $('#company_id').select2({
                placeholder: "Select Company",
                allowClear: true
            });

            $('#contact_type_id').select2({
                placeholder: "Select Contact Type",
                allowClear: true
            });
        });
    </script>
    
@endpush