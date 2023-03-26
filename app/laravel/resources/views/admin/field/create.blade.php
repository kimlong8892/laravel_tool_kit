@extends('layouts.admin')

@section('title', __('Create field'))

@section('content')
    <form action="{{ route('admin.fields.store') }}"
          method="POST">
        @csrf
        @include('admin.field.include.list_field')
        @include('admin.include.save_btn')
    </form>
@endsection
