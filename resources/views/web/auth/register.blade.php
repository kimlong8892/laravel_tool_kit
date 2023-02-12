@extends('layouts.web')

@section('content')
    <div class="row justify-content-center p-3">
        <div class="col-md-6">
            <div class="card">
                <h1 class="card-header">{{ __('Register') }}</h1>

                <div class="card-body">
                    <form method="POST" action="{{ route('web.register') }}">
                        @csrf

                        <div class="form-group row mt-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                {{ __('Name') }}
                                <font style="color: red;">*</font>
                            </label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name') }}">

                                @error('name')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">
                                {{ __('E-Mail Address') }}
                                <font style="color: red;">*</font>
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="text"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}">

                                @error('email')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">
                                {{ __('Password') }}
                                <font style="color: red;">*</font>
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       value="{{ old('password') }}">

                                @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <label for="confirm_password"
                                   class="col-md-4 col-form-label text-md-right">
                                {{ __('Confirm Password') }}
                                <font style="color: red;">*</font>
                            </label>

                            <div class="col-md-6">
                                <input type="password"
                                       class="form-control @error('confirm_password') is-invalid @enderror"
                                       name="confirm_password" value="{{ old('confirm_password') }}">
                                @error('confirm_password')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <label class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6 pt-3 pb-3">
                                @include('web.include.captcha')
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-pen-alt"></i>
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
