@extends('admin.layout.app')


@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-tabs" id="companyTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Contacts</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="domains-tab" data-bs-toggle="tab" data-bs-target="#domains" type="button" role="tab" aria-controls="domains" aria-selected="false">Domains</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="additional-names-tab" data-bs-toggle="tab" data-bs-target="#additional-names" type="button" role="tab" aria-controls="additional-names" aria-selected="false">Additional Names</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="child-company-tab" data-bs-toggle="tab" data-bs-target="#child-company" type="button" role="tab" aria-controls="child-company" aria-selected="false">Sister Concerns</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="trade-reference-tab" data-bs-toggle="tab" data-bs-target="#trade-reference" type="button" role="tab" aria-controls="trade-reference" aria-selected="false">Trade References</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="companyTabContent">
        <div class="tab-pane fade show active p-3" id="details" role="tabpanel" aria-labelledby="details-tab">
            <div class="card-header">
                <div class="d-flex">
                    <h3 class="text-primary text-center">Company Details</h3>
                   
                    <div class="ms-auto">
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                   </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-success"><i class="fa fa-house"></i>&nbsp;{{$company->name}} (ID:{{$company->id}})</h3>
                        {{-- @if($parent)
                            <div class="ms-auto">
                                <a href="{{ route('companies.show', $parent->parent_id) }}" class="btn btn-primary">Parent Company: {{$parent->parent->name}}</a>
                            </div>
                        @endif --}}
                    </div>
                </div>
                <div class="card-body">
                    @if ($company->tags && $company->tags->count())
                        <div class="mb-5">
                            <strong>Tags:</strong>
                            @foreach ($company->tags as $tag)
                                <span style="background-color: {{ $tag->background_color }}; color: {{ $tag->text_color }}; padding: 3px 6px; border-radius: 3px; margin-right: 5px;">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-6 mb-3">
                            <p><strong>Domain:</strong>   
                                @foreach ($company->domains as $domain)
                                    <span class="badge bg-primary text-white rounded">
                                        {{ $domain->domain->name }}
                                    </span>
                                @endforeach                               
                            </p>
                            <p><strong>Business Phone:</strong> {{ $company->business_phone }}</p>
                            <p><strong>Agreement Status:</strong> {{ $company->agreement_status }}</p>
                            <p><strong>USDT Support:</strong> {{ $company->usdt_support }}</p>
                            <p><strong>Credit Limit:</strong> {{ $company->credit_limit }}</p>
                            <p><strong>Operating On:</strong> {{ optional($company->operatingOnCountry)->name ?? '—' }}</p>
                        </div>
            
                        <!-- Column 2 -->
                        <div class="col-md-6 mb-3">                              
                            
                            <p><strong>Based On:</strong> {{ optional($company->basedOnCountry)->name ?? '—' }}</p>                          
                            <p><strong>Business Type:</strong> {{ optional($company->businessType)->name ?? '—' }}</p>
                            <p><strong>Interconnection Type:</strong> {{ optional($company->interconnectionType)->name ?? '—' }}</p>
                            <p><strong>Created At:</strong> {{ $company->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $company->updated_at->format('d M Y, h:i A') }}</p>
                        </div>

                        <div class="col-m">
                            <p><strong>Registered Address:</strong> {{ $company->registered_address }}</p>
                            <p><strong>Office Address:</strong> {{ $company->office_address }}</p>
                            <p><strong>Remarks1:</strong> {{ $company->remarks1 }}</p>
                            <p><strong>Remarks2:</strong> {{ $company->remarks2 }}</p>
                        </div>
                    </div>                                                                
                </div>
            </div>
        </div>

        <div class="tab-pane fade p-3" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Contacts</h3>
                </div>
                <div class="card-body">
    
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->contacts as $contact)
                                    <tr class="align-middle">
                                        <td>{{ $contact->name }}</td>
                                        <td>
                                            <p>{{ $contact->email1 }}</p>
                                            <p>{{ $contact->email2 }}</p>
                                            <p>{{ $contact->phone_number }}</p>
                                        </td>
                                        
                                        <td><a class="btn btn-primary btn-sm text-white" href="{{route('contacts.show',$contact->id)}}"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                @empty
                                    <tr class="align-middle text-center">
                                        <td colspan="3">No contacts available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>  
        </div>

        <div class="tab-pane fade p-3" id="domains" role="tabpanel" aria-labelledby="domains-tab">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Domains</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-dark">Add Domain</h5>
                    <form action="{{ route('add_domain') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <div class="mb-3">
                            <label for="domain_id" class="form-label">Domain</label>
                            <select name="domain_ids[]" id="domain_id" class="form-select border border-primary" required multiple>
                                {{-- <option value="">Select a Domain</option>
                                @foreach($domains as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach --}}
                            </select>
                            @error('domain_ids')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->domains as $domain)
                                    <tr class="align-middle">
                                        <td>{{ $domain->domain->name }}</td>
                                        <td>{{ $domain->domain->status }}</td>
                                        <td>
                                            <form action="{{ route('removeDomain', ['company_id' => $company->id, 'domain_id' => $domain->domain_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this domain?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="align-middle text-center">
                                        <td colspan="3">No contacts available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>  
        </div>

        <div class="tab-pane fade" id="additional-names" role="tabpanel" aria-labelledby="additional-names-tab">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Additional Company Names</h3>
                </div>
                <div class="card-body">  
                    <h5 class="text-dark">Create Additional Company Name</h5>
                    <form action="{{ route('additional_companies.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control border border-primary" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->additionalCompanyNames as $additionalCompany)
                                    <tr class="align-middle">
                                        <td>{{ $additionalCompany->name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editAdditionalCompanyModal-{{ $additionalCompany->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editAdditionalCompanyModal-{{ $additionalCompany->id }}" tabindex="-1" aria-labelledby="editAdditionalCompanyModalLabel-{{ $additionalCompany->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-dark" id="editAdditionalCompanyModalLabel-{{ $additionalCompany->id }}">Edit Additional Company Name</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('additional_companies.update', $additionalCompany->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="name-{{ $additionalCompany->id }}" class="form-label">Name</label>
                                                                    <input type="text" class="form-control border border-primary" id="name-{{ $additionalCompany->id }}" name="name" value="{{ $additionalCompany->name }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('additional_companies.destroy', $additionalCompany->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this additional company name?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="align-middle text-center">
                                        <td colspan="3">No names available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                   
                </div>  
            </div>  
        </div>

        <div class="tab-pane fade" id="child-company" role="tabpanel" aria-labelledby="child-company-tab">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Sister Concerns</h3>
                </div>
                <div class="card-body">  
                    <h5 class="text-dark">Add Child Company</h5>
                    <form action="{{ route('company_chillds.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <div class="mb-3">
                            <select class="form-controll bg-light text-white select2" id="child_company_id" name="child_company_id[]" multiple required>
                                <option value="" disabled>Select a company</option>
                                @foreach ($companies as $childCompany)
                                    <option value="{{ $childCompany->id }}">{{ $childCompany->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>                           
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->childCompanies as $childCompany)
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a href="{{route('companies.show',$childCompany->child->id)}}">{{ $childCompany->child->name}} </a>
                                                    
                                                    @foreach ( $childCompany->child->domains as $domain)
                                                        <span class="badge bg-dark text-white rounded">
                                                            {{ $domain->domain->name }}
                                                        </span>
                                                    @endforeach
                                               </div>
                                               
                                                <form action="{{ route('removeChild', ['parent_id' => $company->id, 'child_company_id' => $childCompany->child_company_id] ) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this child company?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>                                   
                                        </td>                                      
                                    </tr>

                                    
                                    <tr>
                                        <td colspan="1">
                                            <div class="p-2">
                                                <strong>Details:</strong>
                                                <ul class="mb-0">
            
                                                    <li><strong>Name:</strong> {{ $childCompany->child->name }}</li>
                                                    <li><strong>Business Phone:</strong> {{ $childCompany->child->business_phone ?? '—' }}</li>
                                                    <li><strong>Agreement Status:</strong> {{ $childCompany->child->agreement_status ?? '—' }}</li>
                                                    <li><strong>Credit Limit:</strong> {{ $childCompany->child->credit_limit ?? '—' }}</li>
                                                    <li><strong>Registered Address:</strong> {{ $childCompany->child->registered_address ?? '—' }}</li>
                                                    <li><strong>Office Address:</strong> {{ $childCompany->child->office_address ?? '—' }}</li>
                                                    <li><strong>Created At:</strong> {{ $childCompany->child->created_at ? $childCompany->child->created_at->format('d M Y, h:i A') : '—' }}</li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="align-middle text-center">
                                        <td colspan="3">No sister company available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                   
                </div>  
            </div>  
        </div>

        <div class="tab-pane fade" id="trade-reference" role="tabpanel" aria-labelledby="trade-reference-tab">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-primary">Trade References</h3>
                </div>
                <div class="card-body">  
                    <h5 class="text-dark">Add Trade Reference Company</h5>
                    <form action="{{ route('trade_references.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <div class="mb-3">
                            <select class="form-controll bg-light text-white select2" id="trade_reference_id" name="reference_company_ids[]" multiple required>
                                <option value="" disabled>Select a company</option>
                                @foreach ($tradeCompanies as $childCompany)
                                    <option value="{{ $childCompany->id }}">{{ $childCompany->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>                           
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($company->childTradeCompany as $childCompany)
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                               <div>
                                                    {{ $childCompany->child->name}} 
                                                    
                                                    @foreach ( $childCompany->child->domains as $domain)
                                                        <span class="badge bg-dark text-white rounded">
                                                            {{ $domain->domain->name }}
                                                        </span>
                                                    @endforeach
                                               </div>

                                                <form action="{{ route('removeTradeReferences',['parent_id' => $company->id, 'reference_company_id' => $childCompany->child->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trade reference?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm text-white"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>                                   
                                        </td>                                      
                                    </tr>

                                    <tr>
                                        <td colspan="1">
                                            <div class="p-2">
                                                <strong>Details:</strong>
                                                <ul class="mb-0">
            
                                                    <li><strong>Name:</strong> {{ $childCompany->child->name }}</li>
                                                    <li><strong>Business Phone:</strong> {{ $childCompany->child->business_phone ?? '—' }}</li>
                                                    <li><strong>Agreement Status:</strong> {{ $childCompany->child->agreement_status ?? '—' }}</li>
                                                    <li><strong>Credit Limit:</strong> {{ $childCompany->child->credit_limit ?? '—' }}</li>
                                                    <li><strong>Registered Address:</strong> {{ $childCompany->child->registered_address ?? '—' }}</li>
                                                    <li><strong>Office Address:</strong> {{ $childCompany->child->office_address ?? '—' }}</li>
                                                    <li><strong>Created At:</strong> {{ $childCompany->child->created_at ? $childCompany->child->created_at->format('d M Y, h:i A') : '—' }}</li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="align-middle text-center">
                                        <td colspan="3">No references available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                   
                </div>  
            </div>  
        </div>
    </div>      
</div>


@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#child_company_id').select2({
            placeholder: "Select a company",
            allowClear: true
        });
    });

    $(document).ready(function() {
        $('#trade_reference_id').select2({
            placeholder: "Select a company",
            allowClear: true
        });
    });

    // Remember the last active tab
    $(document).ready(function() {
        // Check if a tab was previously selected
        let lastTab = localStorage.getItem('lastActiveTab');
        if (lastTab) {
            let tabElement = $(`[data-bs-target="${lastTab}"]`);
            if (tabElement.length) {
                tabElement.tab('show');
            }
        }

        // Save the active tab on click
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            let activeTab = $(e.target).data('bs-target');
            localStorage.setItem('lastActiveTab', activeTab);
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
                placeholder: 'Select domain',
                minimumInputLength: 0
            });
    });
</script>
@endpush