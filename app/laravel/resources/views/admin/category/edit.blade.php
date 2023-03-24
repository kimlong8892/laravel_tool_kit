@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.categories.update', $category->id) }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        @method('PUT')

        @include('admin.category.include.list_field')

        <div class="form-group">
            <button class="btn btn-primary">
                <i class="fa fa-save"></i>
                {{ __('Save') }}
            </button>
        </div>
    </form>
@endsection
