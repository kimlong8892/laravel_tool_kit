@extends('layouts.web')

@section('title', __('Home page'))

@section('content')
    <div class="row">
        @foreach($listPost as $item)
            <div class="col-md-3 col-6 col-lg-2 mb-2">
                <div class="card p-2">
                    <img src="{{ $item->getImage() }}" width="100%">
                    <h5 class="mt-0 mb-0 text-center p-2">{{ $item->name }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $listPost->appends(request()->input())->links() }}
    </div>
@endsection


