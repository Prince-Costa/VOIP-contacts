@extends('admin.layout.app')

@section('content')

    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="card col-sm-12 col-xl-6 offset-xl-3 text-light">
                <div class="rounded h-100 p-4">
                    <h3 class="mb-4 text-center">Login</h3>
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control border border-primary" id="email" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control border border-primary" id="password" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection    