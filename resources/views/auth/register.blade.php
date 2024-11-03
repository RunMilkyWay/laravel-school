@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mt-5">{{ __('messages.register_title') }}</h2>

            <!-- Display success message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('messages.close') }}"></button>
                </div>
            @endif

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="mt-3">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">{{ __('messages.register') }}</button>
            </form>
        </div>
    </div>
@endsection
