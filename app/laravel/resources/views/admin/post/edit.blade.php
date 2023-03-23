@extends('layouts.admin')

@section('title', __('Edit post'))

@section('content')
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" id="form-main">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-8">

                @include('admin.post.include.list_field_left')
            </div>
            <div class="col-4">
                @include('admin.post.include.list_field_right')

                <div class="form-group mt-3">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-save"></i>
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    @include('admin.post.include.detail_js')
@endsection
