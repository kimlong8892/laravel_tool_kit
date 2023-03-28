@if(!empty($listProduct) && count($listProduct) > 0)
    <div class="mt-2 row align-items-center">
        @if(!empty($listProductPagination['page']) && !empty($listProductPagination['hasNextPage']))
            <div class="col-5">
                @if($listProductPagination['page'] > 1)
                    <button class="btn btn-primary btn-change-page-product-select-ajax"
                            type="button"
                            data-id="{{ request()->get('id') }}"
                            data-page="{{ $listProductPagination['page'] - 1 }}">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                @endif
            </div>
            <div class="col-2 text-center">
                {{ __('Current page') }}: {{ $listProductPagination['page'] }}
            </div>
            <div class="col-5 text-right">
                <button class="btn btn-primary btn-change-page-product-select-ajax"
                        type="button"
                        data-id="{{ request()->get('id') }}"
                        data-page="{{ $listProductPagination['page'] + 1 }}">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        @endif
    </div>
    <div style="height: 400px; overflow: auto;" class="fixed-table-div mt-2">
        <table class="table table-bordered table-fixed">
            <tr>
                <th width="50%" nowrap>{{ __('Product name')  }}</th>
                <th width="20%" nowrap>{{ __('Product image') }}</th>
                <th width="15%" nowrap>{{ __('Product price') }}</th>
                <th width="15%" nowrap>{{ __('Action') }}</th>
            </tr>
            @foreach($listProduct as $product)
                <tr>
                    <td>{{ $product['productName'] ?? '' }}</td>
                    <td>
                        <img src="{{ $product['imageUrl'] ?? '' }}" width="100%">
                    </td>
                    <td>{{ formatVnd($product['price'] ?? '', false) }}</td>
                    <td>
                        <button class="btn btn-primary" type="button">
                            <i class="fa fa-plus"></i>
                            {{ __('Chose') }}
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
