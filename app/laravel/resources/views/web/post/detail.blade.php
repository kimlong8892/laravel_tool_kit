@extends('layouts.web')

@section('title', $post->name ?? '')

@section('content')
    <style>
        #post-content img {
            max-width: 100%;
        }

        .border-radius-10 {
            border-radius: 10px;
        }
    </style>

    <div class="mt-2 mb-2">
        <img src="{{ $post->getImage() }}" alt="{{ $post->name ?? '' }}"
             class="border-radius-10"
             width="100%"
             style="height: 30vh;">
    </div>


    <div id="post-content" class="card p-3">
        {!! $post->content ?? '' !!}
    </div>
@endsection
