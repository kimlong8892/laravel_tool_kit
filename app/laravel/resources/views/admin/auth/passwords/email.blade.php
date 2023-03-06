@extends('layouts.admin_login_forgot')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="login-wrap p-4 p-md-5">
                <div class="icon d-flex align-items-center justify-content-center">
                    <span class="fa fa-user"></span>
                </div>
                <h3 class="text-center mb-4">{{ __('forgot password') }}</h3>
                @error('error_password_reset')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <form action="{{ route('admin.password.email') }}" class="login-form" method="POST">
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
                        @include('admin.include.captcha')
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                            {{ __('send link reset password') }}
                        </button>
                    </div>
                    <div class="form-group text-right">
                        <a href="{{ route('admin.login') }}">{{ __('your has account, login now') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
