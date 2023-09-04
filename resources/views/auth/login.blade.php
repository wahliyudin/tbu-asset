@extends('layouts.auth')

@section('content')
    {{-- <form method="POST" action="{{ route('login') }}">
        @csrf --}}
    @if (session()->has('error'))
        <div class="row">
            <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
                <i class="ki-duotone ki-message-text-2 fs-2hx text-light me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                        class="path2"></span><span class="path3"></span></i>
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <h4 class="mb-2 light">Error!</h4>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button"
                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                    data-bs-dismiss="alert">
                    <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
            </div>
        </div>
    @endif
    <div class="text-center mb-11">
        <h1 class="text-dark fw-bolder mb-3">
            Login
        </h1>
    </div>
    <div class="row g-3 mb-9">
        <div class="col-md-12">
            <a href="{{ route('sso.login') }}"
                class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                <img alt="Logo" src="{{ asset('assets/media/logos/tbu-crop.png') }}" class="h-15px me-3">
                Sign in with HRIS
            </a>
        </div>
    </div>
    {{--
        <div class="fv-row mb-8">
            <input type="email" placeholder="Email" name="email" autocomplete="off"
                class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}"
                required autocomplete="email" autofocus />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off"
                class="form-control bg-transparent @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="d-grid mb-10 mt-8">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                <span class="indicator-label">
                    Submit</span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Not a Member yet?

            <a href="{{ route('register') }}" class="link-primary">
                Register
            </a>
        </div> --}}
    {{-- </form> --}}
@endsection
