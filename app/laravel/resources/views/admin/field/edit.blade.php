@extends('layouts.admin')

@section('title', __('Edit field'))

@section('content')
    <form action="{{ route('admin.fields.update', $field->id) }}"
          method="POST">
        @method('PUT')
        @csrf
        @include('admin.field.include.list_field')
        @include('admin.include.save_btn')
    </form>
@endsection
