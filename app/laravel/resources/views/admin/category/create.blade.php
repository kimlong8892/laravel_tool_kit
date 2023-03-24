@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.categories.store') }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        @include('admin.category.include.list_field')

        <div class="form-group">
            <button class="btn btn-primary">
                <i class="fa fa-save"></i>
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
