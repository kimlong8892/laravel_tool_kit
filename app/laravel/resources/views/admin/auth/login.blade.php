@extends('layouts.admin_login_forgot')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="login-wrap p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="fa fa-user"></span>
                </div>
                <h3 class="text-center mb-4">{{ __('login') }}</h3>
                @error('error_login')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <form action="{{ route('admin.login') }}" class="login-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="email" class="form-control rounded-left @error('email') is-invalid @enderror" placeholder="{{ __('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control rounded-left @error('password') is-invalid @enderror" placeholder="{{ __('password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        @include('admin.include.captcha')
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="form-group d-md-flex">
                        <div class="w-50">
                            <label class="checkbox-wrap checkbox-primary">
                                {{ __('Remember Me') }}
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-50 text-md-right">
                            <a href="{{ route('admin.password.request') }}">{{ __('Forgot Password') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
