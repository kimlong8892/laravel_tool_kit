@extends('layouts.web')

@section('title', __('Home page'))

@section('content')
    <div class="row">
        @foreach($listPost as $item)
            @include('web.post.include.post_item_in_list', ['item' => $item])
        @endforeach
    </div>
    <div>
        {{ $listPost->appends(request()->input())->links() }}
    </div>
@endsection


