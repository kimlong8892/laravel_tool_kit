@extends('layouts.admin')

@section('title', __('Create category'))

@section('content')
    <form action="{{ route('admin.categories.store') }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        @include('admin.category.include.list_field')
        @include('admin.include.save_btn')
    </form>
@endsection
