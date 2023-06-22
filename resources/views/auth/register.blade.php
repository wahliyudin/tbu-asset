@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">
                Register
            </h1>
        </div>

        <div class="fv-row mb-8">
            <input type="number" placeholder="NIK" class="form-control bg-transparent @error('nik') is-invalid @enderror"
                name="nik" value="{{ old('nik') }}" required autocomplete="nik" />
            @error('nik')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-8">
            <input type="text" placeholder="Name" class="form-control bg-transparent @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" required autocomplete="name" />
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-8">
            <input type="email" placeholder="Email"
                class="form-control bg-transparent @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-8">
            <input type="password" class="form-control bg-transparent @error('password') is-invalid @enderror"
                name="password" placeholder="Password" required autocomplete="new-password" />

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-8">
            <input placeholder="Password Confirm" name="password_confirmation" type="password"
                class="form-control bg-transparent" required autocomplete="new-password" />
        </div>

        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                <span class="indicator-label">
                    Submit</span>

                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>

        <div class="text-gray-500 text-center fw-semibold fs-6">
            Already have an Account?

            <a href="{{ route('login') }}" class="link-primary fw-semibold">
                Login
            </a>
        </div>
    </form>
@endsection
