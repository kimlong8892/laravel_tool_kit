@extends('layouts.web')

@section('title', __('Home page'))

@section('content')
    <form action="{{ route('web.search_product') }}" method="GET">
        <div class="form-group">
            <input type="text" class="form-control" name="search">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>

    <div class="row">
        @foreach($listPost as $item)
            @include('web.post.include.post_item_in_list', ['item' => $item])
        @endforeach
    </div>
    <div>
        {{ $listPost->appends(request()->input())->links() }}
    </div>
@endsection


