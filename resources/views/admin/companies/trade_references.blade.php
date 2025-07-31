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
                        Add Trade Reference Company
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('add_trade_references') }}" method="POST">
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
                                        <label class="mb-3" for="trade_reference_id">Reference Company</label>
                                        <select class="form-controll bg-light text-white select2" id="trade_reference_id" name="trade_reference_id[]" multiple required>
                                            <option value="" disabled>Select a company</option>
                                            @foreach ($companies as $key => $childCompany)
                                                <option value="{{ $key }}">{{ $childCompany }}</option>
                                            @endforeach
                                        </select>
                                        @error('trade_reference_id')
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

            <h3 class="mb-5">Trade References</h3>

            <div class="table-responsive">
                <table class="table table-striped" id="tradeReferanceTable">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Reference</th>                                              
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($groups as $parentId => $childGroup)
                        
                            @php
                                $parent = $childGroup->first()->parent;
                            @endphp
                            <tr>
                                <td>
                                    {{ $parent->name ?? 'N/A' }} <br>
                                    {{ $parent->basedOnCountry->name ?? 'N/A' }} <br>
                                    {{ $parent->operatingOnCountry->name ?? 'N/A' }} <br>
                                    {{ $parent->businessType->name ?? 'N/A' }} <br>
                                    {{ $parent->interConnectionType->name ?? 'N/A' }} <br>
                                    @if ($parent->tags->isNotEmpty())
                                        <br>Tags: 
                                        @foreach($parent->tags as $tag)
                                            {{ $tag->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </td>
                            
                                <td>
                                    @foreach($childGroup as $child)
                                        {{ $child->child->name ?? 'N/A' }} <br>
                                        {{ $child->child->basedOnCountry->name ?? 'N/A' }} <br>
                                        {{ $child->child->operatingOnCountry->name ?? 'N/A' }} <br>                    
                                        {{ $child->child->businessType->name ?? 'N/A' }} <br>                    
                                        {{ $child->child->interConnectionType->name ?? 'N/A' }} 
                                        @if ($child->child->tags->isNotEmpty())
                                            <br>Tags: 
                                            @foreach($child->child->tags as $tag)
                                                {{ $tag->name }}@if(!$loop->last), @endif
                                            @endforeach
                                            
                                        @endif
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach --}}
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
        $('#tradeReferanceTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: "{{ route('trade_references.index') }}",
            columns: [
                { data: 'parent_info', name: 'parent_info' },
                { data: 'children_info', name: 'children_info' },               
            ]
        });

        $('#trade_reference_id').select2({
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
    });
</script>
@endpush