@extends('layouts.web')

@section('content')
    <div class="card p-3">
        <div class="text-center row align-items-center">
            <div class="col-6">
                <h3>{{ $product->productName }}</h3>
                <h4 class="mt-2">{{ __('Price') }}: {{ formatVnd($product->price) }}</h4>
                <div>
                    <img src="{{ $product->imageUrl }}" alt="{{ $product->productName }}" width="50%">
                </div>
            </div>

            <div class="col-6">

                <table class="table table-bordered">
                    <tr>
                        <th colspan="2">
                            <h4 class="mt-0 mb-0" class="text-danger">{{ __('History price') }}</h4>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <h5 class="text-primary mt-0 mb-0">{{ __('History product price date') }}</h5>
                        </th>
                        <th>
                            <h5 class="text-primary mt-0 mb-0">{{ __('Price') }}</h5>
                        </th>
                    </tr>
                    @foreach($product->ProductsHistoryPrice as $historyPrice)
                        <tr>
                            <td>{{ $historyPrice->created_at }}</td>
                            <td>{{ formatVnd($historyPrice->price) }}</td>
                        </tr>
                    @endforeach
                </table>


                <a href="{{ $product->offerLink }}" target="_blank">
                    <div class="mb-2 mt-2">
                        <img src="{{ asset('images_site/shopee_icon.png') }}" width="64px">
                    </div>
                    <span>{{ __('Buy in shopee') }}</span>
                    <i class="fa fa-cart-shopping" style="color: orange;"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
