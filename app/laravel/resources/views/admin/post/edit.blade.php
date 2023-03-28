@extends('layouts.admin')

@section('title', __('Edit post'))

@section('content')
    <form action="{{ route('admin.posts.update', $post->id) }}"
          method="POST" id="form-main">
        @method('PUT')
        @csrf

        @include('admin.include.save_btn')

        <div class="row">
            <div class="col-8">
                @include('admin.post.include.list_field_left')
            </div>
            <div class="col-4">
                @include('admin.post.include.list_field_right')
            </div>
        </div>
    </form>
@endsection

@section('js')
    @include('admin.post.include.detail_js')
@endsection
