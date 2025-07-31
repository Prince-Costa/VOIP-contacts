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
        <div class="col-md-12 mb-5">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed text-white fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add Child Company
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('add_company_chillds') }}" method="POST">
                            @csrf      
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="mb-3" for="company_id">Parent Company</label>
                                        <select class="form-controll bg-light text-white select2" id="company_id" name="company_id" required>
                                            <option value="" disabled>Select a company</option>
                                            @foreach ($companies as $key => $company)
                                                <option value="{{ $key }}">{{ $company }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="mb-3" for="child_company_id">Child Company</label>
                                        <select class="form-controll bg-light text-white select2" id="child_company_id" name="child_company_id[]" multiple required>
                                            <option value="" disabled>Select a company</option>
                                            @foreach ($companies as $key => $childCompany)
                                                <option value="{{ $key }}">{{ $childCompany }}</option>
                                            @endforeach
                                        </select>
                                        @error('child_company_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                   </div>
                </div>
            </div>          
        </div>

        <div class="col-md-12">
            <h3 class="mb-5">Sister Concerns</h3>

            <div class="table-responsive">
                <table class="table table-striped" id="sisterCompaniesTable">
                    <thead>
                        <tr>
                            <th>Parent</th>
                            <th>Childs</th>                                              
                        </tr>
                    </thead>
                    <tbody>                     
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
        $('#sisterCompaniesTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: "{{ route('company_chillds.index') }}",
            columns: [
                { data: 'parent_info', name: 'parent_info' },
                { data: 'children_info', name: 'children_info' },
            ]
        });
    });

    $('#child_company_id').select2({
        placeholder: "Select a company",
        allowClear: true,
        width: '100%'
    });

    $('#company_id').select2({
        placeholder: "Select a company",
        allowClear: true,
        width: '100%'
    });

    // Prevent auto-selecting the first option
    $('#company_id').val(null).trigger('change');
</script>
@endpush