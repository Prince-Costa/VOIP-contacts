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

            

            <div class="card mt-4">
                <div class="card-header">
                   <div class="d-flex">
                    <h3 class="text-primary text-center">Contact Details</h3>
                    <div class="ms-auto">
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                   </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        @if(isset($contact->name) && $contact->name)
                            <h3 class="text-success"><i class="fa-solid fa-address-card"></i>&nbsp;{{ $contact->name }}</h3>
                        @endif
                    </div>
                    <div class="card-body">
                        
                                <p><strong>Email1:</strong> {{ isset($contact->email1) && $contact->email1 ? $contact->email1 : '—' }}</p>
                                <p><strong>Email2:</strong> {{ isset($contact->email2) && $contact->email2 ? $contact->email2 : '—' }}</p>
                                <p><strong>Phone Number:</strong> {{ isset($contact->phone_number) && $contact->phone_number ? $contact->phone_number : '—' }}</p>
                                <p><strong>Contact Type:</strong> {{ isset($contact->contactType->name) && $contact->contactType->name ? $contact->contactType->name : '—' }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <h5 class="text-center text-primary">Company Details</h5>

                    <div class="card-body">
                        <div class="row">
                            <!-- Column 1 -->
                            <div class="col-md-6 mb-3">
                                <p><strong>Name:</strong> {{ isset($contact->company->name) && $contact->company->name ? $contact->company->name : '—' }}</p>
                                <p><strong>Domain:</strong> {{ isset($contact->company->domain_name) && $contact->company->domain_name ? $contact->company->domain_name : '—' }}</p>
                                <p><strong>Registered Address:</strong> {{ isset($contact->company->registered_address) && $contact->company->registered_address ? $contact->company->registered_address : '—' }}</p>
                                <p><strong>Office Address:</strong> {{ isset($contact->company->office_address) && $contact->company->office_address ? $contact->company->office_address : '—' }}</p>
                                <p><strong>Business Phone:</strong> {{ isset($contact->company->business_phone) && $contact->company->business_phone ? $contact->company->business_phone : '—' }}</p>
                                <p><strong>Agreement Status:</strong> {{ isset($contact->company->agreement_status) && $contact->company->agreement_status ? $contact->company->agreement_status : '—' }}</p>
                                <p><strong>USDT Support:</strong> {{ isset($contact->company->usdt_support) && $contact->company->usdt_support ? $contact->company->usdt_support : '—' }}</p>                              
                            </div>

                            <!-- Column 2 -->
                            <div class="col-md-6 mb-3">    
                                <p><strong>Credit Limit:</strong> {{ isset($contact->company->credit_limit) && $contact->company->credit_limit ? $contact->company->credit_limit : '—' }}</p>                          
                                <p><strong>Operating On:</strong> {{ isset($contact->company->operatingOnCountry->name) && $contact->company->operatingOnCountry->name ? $contact->company->operatingOnCountry->name : '—' }}</p>
                                <p><strong>Based On:</strong> {{ isset($contact->company->basedOnCountry->name) && $contact->company->basedOnCountry->name ? $contact->company->basedOnCountry->name : '—' }}</p>                               
                                <p><strong>Business Type:</strong> {{ isset($contact->company->businessType->name) && $contact->company->businessType->name ? $contact->company->businessType->name : '—' }}</p>
                                <p><strong>Interconnection Type:</strong> {{ isset($contact->company->interconnectionType->name) && $contact->company->interconnectionType->name ? $contact->company->interconnectionType->name : '—' }}</p>
                                <p><strong>Created At:</strong> {{ isset($contact->company->created_at) && $contact->company->created_at ? $contact->company->created_at->format('d M Y, h:i A') : '—' }}</p>
                                <p><strong>Updated At:</strong> {{ isset($contact->company->updated_at) && $contact->company->updated_at ? $contact->company->updated_at->format('d M Y, h:i A') : '—' }}</p>
                            </div>
                        </div>
                
                        @if (isset($contact->company->tags) && $contact->company->tags->count())
                            <div class="mt-3">
                                <strong>Tags:</strong>
                                @foreach ($contact->company->tags as $tag)
                                    <span style="background-color: {{ $tag->background_color }}; color: {{ $tag->text_color }}; padding: 3px 6px; border-radius: 3px; margin-right: 5px;">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>        
</div>


@endsection
