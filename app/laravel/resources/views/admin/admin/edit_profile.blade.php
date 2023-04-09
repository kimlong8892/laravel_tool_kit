@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.update_profile') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" value="{{ $admin->name }}" name="name">
            @include('admin.include.text_error_field', ['name' => 'name'])
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="text" class="form-control" name="password">
            @include('admin.include.text_error_field', ['name' => 'password'])
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm password') }}</label>
            <input type="text" class="form-control" name="password_confirmation">
            @include('admin.include.text_error_field', ['name' => 'password_confirmation'])
        </div>
        <div class="form-group">
            <button class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
@endsection
