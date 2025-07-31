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
            <h3 class="mb-5">Edit Contact</h3>

            <form action="{{ route('contacts.update', $contact->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span class="text-primary">*</span></label>
                            <input type="text" name="name" id="name" class="form-control border border-primary"  placeholder="Enter Contact Name" value="{{ old('name', $contact->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email1" class="form-label">Email 1<span style="font-size:12px;">(unique)</span><span class="text-primary">*</span></label>
                            <input type="email" name="email1" id="email1" class="form-control border border-primary"  placeholder="Enter Contact email1" value="{{ old('email1', $contact->email1) }}">
                            @error('email1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email2" class="form-label">Email 2<span style="font-size:12px;">(unique)</span></label>
                            <input type="email" name="email2" id="email2" class="form-control border border-primary"  placeholder="Enter Contact email2" value="{{ old('email2', $contact->email2) }}">
                            @error('email2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control border border-primary"  placeholder="Enter Contact phone number" value="{{ old('phone_number', $contact->phone_number) }}">
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Company</label>
                            <select name="company_id" id="company_id" class="form-select border border-primary">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $contact->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach                             
                            </select>
                        </div>
                        @error('company_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_type_id" class="form-label">Contact Type</label>
                            <select name="contact_type_id" id="contact_type_id" class="form-select border border-primary">
                                <option value="">Select Contact type</option>
                                @foreach($contactTypes as $contactType)
                                    <option value="{{ $contactType->id }}" {{ old('contact_type_id', $contact->contact_type_id) == $contactType->id ? 'selected' : '' }}>{{ $contactType->name }}</option>
                                @endforeach                             
                            </select>
                        </div>
                        @error('contact_type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>       
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#company_id').select2({
                placeholder: "Select Contact",
                allowClear: true
            });

            $('#contact_type_id').select2({
                placeholder: "Select Contact",
                allowClear: true
            });
        });
    </script>
@endpush