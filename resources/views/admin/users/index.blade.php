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
        <div class="col-lg-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed text-white fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add User
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Name') }}<span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control border border-primary" value="{{ old('name') }}"  autocomplete="name">
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control border border-primary" value="{{ old('email') }}" autocomplete="username">
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">{{ __('Role') }}</label>
                                        <select id="role" name="role" class="form-control border border-primary">
                                            <option value=""  selected>{{ __('Select Role') }}</option>
                                            
                                            <option value="admin">
                                                Admin
                                            </option>
                    
                                            <option value="modaretor">
                                                Modaretor
                                            </option>
                                            
                                        </select>
                                        @error('role')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="companyId" class="form-label">{{ __('Company') }}</label>
                                        <select id="companyId" name="company_id" class="form-control border border-primary">
                                            <option value=""  selected>{{ __('Select Company') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }}<span class="text-danger">*</span></label>
                                        <input type="password" id="password" name="password" class="form-control border border-primary" autocomplete="new-password">
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}<span class="text-danger">*</span></label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border border-primary" required autocomplete="new-password">
                                        @error('password_confirmation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
            
            
                            <button type="submit" class="btn btn-primary mt-3">
                                {{ __('Register') }}
                            </button>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-lg-0 mt-5">

            <div class="rounded h-100 p-2">
                <h3 class="mb-5">Users</h3>
                <div class="table-responsive">
                    <table class="table table-striped border rounded">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $user->name }}                               
                                    </td>
                                    <td>
                                        {{ $user->email }}                               
                                    </td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info text-white"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#companyId').select2({
            placeholder: 'Select Company',
            allowClear: true
        });
    });
</script>
@endpush