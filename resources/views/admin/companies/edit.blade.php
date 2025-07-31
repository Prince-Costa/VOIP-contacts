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
        <div class="col-md-12 px-5">
            <h3 class="mb-5">Edit Company</h3>

            <form action="{{ route('companies.update', $company->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name<span class="text-primary">*</span></label>
                        <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Company Name" value="{{ old('name', $company->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="domain_id" class="form-label">Domain</label>
                        <select name="domain_ids[]" id="domain_id" class="form-select border border-primary" multiple>
                            {{-- <option value="">Select Domain</option>
                            @foreach($domains as $domain)
                            <option value="{{ $domain->id }}" {{ in_array($domain->id, old('tags', $company->domains->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $domain->name }}</option>
                            @endforeach --}}
                        </select>
                        @error('domain_ids')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="registered_address" class="form-label">Registered Address</label>
                        <textarea type="text" name="registered_address" id="registered_address" class="form-control border border-primary" placeholder="Enter Registered Address">{{ old('registered_address', $company->registered_address) }}</textarea>
                        @error('registered_address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="office_address" class="form-label">Office Address</label>
                        <textarea type="text" name="office_address" id="office_address" class="form-control border border-primary" placeholder="Enter Office Address">{{ old('office_address', $company->office_address) }}</textarea>
                        @error('office_address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>

                    <div class="col-md-6 mb-3">                    
                        <label for="business_phone" class="form-label">Company phone number</label>
                        <input type="text" name="business_phone" id="business_phone" class="form-control border border-primary" placeholder="Enter Company Phone Number" value="{{ old('business_phone', $company->business_phone) }}">
                        @error('business_phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror                        
                    </div>

                    <div class="col-md-6 mb-3">                    
                        <label for="credit_limit" class="form-label">Total Credit Limit</label>
                        <input type="text" name="credit_limit" id="credit_limit" class="form-control border border-primary" placeholder="Enter Total Credit Limit" value="{{ old('credit_limit', $company->credit_limit) }}">
                        @error('credit_limit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror                        
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="based_on" class="form-label">Origin Country</label>
                        <select name="based_on" id="based_on" class="form-select border border-primary">
                            <option value="">Select Origin Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('based_on', $company->based_on) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('based_on')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="operating_on" class="form-label">Operating Country</label>
                        <select name="operating_on" id="operating_on" class="form-select border border-primary">
                            <option value="">Select Operating Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('operating_on', $company->operating_on) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('operating_on')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="business_type" class="form-label">Types of Business with our Company</label>
                        <select name="business_type" id="business_type" class="form-select border border-primary">
                            <option value="">Select Types of Business</option>
                            @foreach($businessTypes as $businessType)
                                <option value="{{ $businessType->id }}" {{ old('business_type', $company->business_type) == $businessType->id ? 'selected' : '' }}>{{ $businessType->name }}</option>
                            @endforeach
                        </select>
                        @error('business_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="interconnection_type" class="form-label">Interconnection Status with our Company</label>
                        <select name="interconnection_type" id="interconnection_type" class="form-select border border-primary">
                            <option value="">Select Interconnection Status</option>
                            @foreach($interconnectionTypes as $interconnectionType)
                                <option value="{{ $interconnectionType->id }}" {{ old('interconnection_type', $company->interconnection_type) == $interconnectionType->id ? 'selected' : '' }}>{{ $interconnectionType->name }}</option>
                            @endforeach
                        </select>
                        @error('interconnection_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="agreement_status" class="form-label">Agreement Status</label>
                        <select name="agreement_status" id="agreement_status" class="form-select border border-primary">
                            <option value="">Select Agreement Status</option>
                            <option value="Completed" {{ old('agreement_status', $company->agreement_status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Pending for Clients Signature" {{ old('agreement_status', $company->agreement_status) == 'Pending for Clients Signature' ? 'selected' : '' }}>Pending for Clients Signature</option>
                            <option value="Have to Fillup & Sign" {{ old('agreement_status', $company->agreement_status) == 'Have to Fillup & Sign' ? 'selected' : '' }}>Have to Fillup & Sign</option>
                            <option value="Not Yet" {{ old('agreement_status', $company->agreement_status) == 'Not Yet' ? 'selected' : '' }}>Not Yet</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="usdt_support" class="form-label">Support USDT</label>
                        <select name="usdt_support" id="usdt_support" class="form-select border border-primary">                        
                            <option value="Yes" {{ old('usdt_support', $company->usdt_support) == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('usdt_support', $company->usdt_support) == 'No' ? 'selected' : '' }}>No</option>                      
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="remarks1" class="form-label">Remarks1</label>
                        <textarea type="text" name="remarks1" id="remarks1" class="form-control border border-primary"  placeholder="Add note">{{ $company->remarks2 }}</textarea>
                        @error('remarks1')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="remarks2" class="form-label">Remarks2</label>
                        <textarea type="text" name="remarks2" id="remarks2" class="form-control border border-primary"  placeholder="Add note">{{ $company->remarks2 }}</textarea>
                        @error('remarks2')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror      
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <select name="tags[]" id="tags" class="form-select border border-primary" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $company->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

               <div class="d-flex">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancle</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>       
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tags').select2({
            placeholder: "Select Tags",
            allowClear: true
            });

            $('#based_on').select2({
            placeholder: "Select Origin Country",
            allowClear: true
            });

            $('#operating_on').select2({
            placeholder: "Select Operating Country",
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
            placeholder: 'Select domain',
            minimumInputLength: 0
            });

            // Set selected domains after AJAX init
            @php            
            $selectedDomainsJson = json_encode($selectedDomains);
            @endphp

            let selectedDomains = {!! $selectedDomainsJson !!};
            if(selectedDomains.length > 0) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getDomains') }}',
                data: { ids: selectedDomains },
                success: function(data) {
                let options = [];
                Object.entries(data).forEach(([id, text]) => {
                    options.push(new Option(text, id, true, true));
                });
                $('#domain_id').append(options).trigger('change');
                }
            });
            }
        });
    </script>
@endpush