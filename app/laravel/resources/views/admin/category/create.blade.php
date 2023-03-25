@extends('layouts.admin')

@section('title', __('Create category'))

@section('content')
    <form action="{{ route('admin.categories.store') }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        @include('admin.category.include.list_field')

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
