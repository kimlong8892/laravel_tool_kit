@extends('layouts.admin')

@section('title', __('Edit category'))

@section('content')
    <form action="{{ route('admin.categories.update', $category->id) }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        @method('PUT')

        @include('admin.category.include.list_field')
        @include('admin.include.save_btn')
    </form>
@endsection
