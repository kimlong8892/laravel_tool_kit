@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.products.index') }}" method="GET">
        <div class="row">
            <div class="form-group col-10">
                <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}"
                       placeholder="{{ __('Search product') }}">
            </div>
            <div class="form-group col-2">
                <button class="btn btn-primary">
                    <i class="fa fa-search"></i>
                    {{ __('Search product') }}
                </button>
            </div>
        </div>
    </form>

    <table class="table table-bordered mt-2">
        <tr>
            <th width="10%">{{ __('itemId') }}</th>
            <th width="10%">{{ __('price') }}</th>
            <th width="10%">{{ __('imageUrl') }}</th>
            <th width="70%">{{ __('productName') }}</th>
        </tr>
        @if(!empty($listProductShopeeData))
            @foreach($listProductShopeeData as $product)
                <tr>
                    <td>{{ $product['itemId'] ?? '' }}</td>
                    <td>{{ $product['price'] ?? '' }}</td>
                    <td>
                        <img src="{{ $product['imageUrl'] ?? '' }}" alt="" width="100%">
                    </td>
                    <td>
                        <a href="{{ $product['productLink'] ?? '' }}">{{ $product['productName'] ?? '' }}</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

@endsection
