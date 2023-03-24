@extends('layouts.admin')

@section('title', __('Edit field'))

@section('content')
    <form action="{{ route('admin.fields.update', $field->id) }}"
          method="POST">
        @method('PUT')
        @csrf
        @include('admin.field.include.list_field')

        <div class="row">
            <div class="col-12">
                <div class="form-group mt-3">
                    <button class="btn btn-primary w-100 fixed-bottom">
                        <i class="fa fa-save"></i>
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
