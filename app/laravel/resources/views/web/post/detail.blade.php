@extends('layouts.web')

@section('title', $post->name ?? '')

@section('head')
    <meta property="og:title" content="{{ $post->name ?? '' }}"/>
    <meta property="og:image" content="{{ $post->getImage() }}"/>
    <meta property="og:description"
          content="{{ $post->name ?? '' }}"/>
@endsection

@section('content')
    <style>
        #post-content img {
            max-width: 100%;
        }

        .border-radius-10 {
            border-radius: 10px;
        }
    </style>

    <div class="mt-2 mb-2 card p-3">
        <div class="mb-4 row align-items-center">
            <div class="col-6">
                <h1 class="font-weight-bold text-uppercase text-bold mb-0 pb-0 text-center">{{ $post->name ?? '' }}</h1>
            </div>

            <div class="col-6">
                <img src="{{ $post->getImage() }}" alt="{{ $post->name ?? '' }}"
                     class="border-radius-10"
                     width="100%">
            </div>
        </div>
    </div>

    <div id="post-content" class="card p-3">
        {!! $post->content ?? '' !!}
    </div>

    <div class="card p-3 m-0 mt-4">
        <div class="row">
            <div class="col-12">
                <h4>{{ __('List product') }}</h4>
            </div>
        </div>
        <div class="row">
            @foreach($post->Products as $key => $product)
                <div class="col-12">
                    <a href="#product-div-{{ $product->id }}">
                        <p class="mt-2"><b>{{ $key + 1 }}</b>. {{ $product->productName }}
                            - {{ formatVnd($product->price, false) }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    @foreach($post->Products as $keyProduct => $product)
        @php
            $listImage = array_merge([$product->imageUrl], json_decode($product->pivot->images, true) ?? []);

            if (!empty($listImage)) {
                foreach ($listImage as $key => $item) {
                    $listImage[$key] = getImageInProductPost($item, $post->id);
                }
            }
        @endphp

        <div class="row m-0 mt-4 card p-3">
            <div class="col-12" id="product-div-{{ $product->id }}">
                <h5>
                    <a href="{{ route('web.product.detail', $product->id) }}">
                        {{ $keyProduct + 1 }}. {{ $product->productName }} - {{ formatVnd($product->price, false) }}
                    </a>
                </h5>
                <div class="row align-items-center">
                    @foreach($listImage as $imageUrl)
                        <div class="p-1 col-2">
                            <img src="{{ $imageUrl }}" alt="" width="100%">
                        </div>
                    @endforeach
                </div>
                <div>
                    {!! $product->pivot->content !!}
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('js')
@endsection
