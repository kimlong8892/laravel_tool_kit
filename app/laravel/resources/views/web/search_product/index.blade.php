@extends('layouts.web')

@section('content')
    @if(!empty($listProduct))
        <div class="row">
            <div class="col-12">
                {{ $listProduct->appends(request()->input())->links() }}
            </div>
        </div>

        <div class="row mt-2">
            @foreach($listProduct as $product)
                <div class="col-2">
                    <img src="{{ $product->imageUrl }}" alt="{{ $product->productName }}" width="100%">
                    <div class="p-1">
                        <h5 class="text-bold mt-2 mb-0 text-center">
                            <p class="mb-0">{{ formatVnd($product->price) }}</p>
                            <p class="mt-0 mb-1">{{ $product->EcSite->name }}</p>
                        </h5>
                        <p class="mt-0 mb-2">
                            <a href="{{ $product->offerLink }}" target="_blank">
                                <i class="fa fa-link"></i>
                                {{ $product->productName }}
                            </a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                {{ $listProduct->appends(request()->input())->links() }}
            </div>
        </div>
    @endif
@endsection
