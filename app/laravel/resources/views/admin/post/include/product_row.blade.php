@php
    if (!isset($rowIndex)) {
         $rowIndex = time() . rand(1111, 99999) * rand(1111, 888888);
    }

    $nameField = 'product_row';
@endphp

<div class="mt-4 card p-2">
    @if(!empty($productRow))
        <input type="hidden" name="{{ $nameField }}[{{ $rowIndex }}][is_update]" value="1">
        <input type="hidden" name="{{ $nameField }}[{{ $rowIndex }}][product_id_old]" value="{{ $productRow->id }}">
    @endif

    <div class="form-group">
        <label for="{{ $nameField }}[{{ $rowIndex }}][product]">{{ __('Product') }}</label>
        <div class="row">
            <div class="col-10">
                <input type="text" class="form-control input-search-product-ajax" data-id="{{ $rowIndex }}">
            </div>
            <div class="col-2">
                <button class="btn btn-primary w-100 btn-search-product-ajax"
                        data-id="{{ $rowIndex }}"
                        type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 div-search-product-ajax" data-id="{{ $rowIndex }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="font-weight-bold text-uppercase">
            @if(!empty($productRow) && !empty($productRow->productName) && !empty($productRow->itemId))
                <input type="hidden" data-id={{ $rowIndex }} value="{{ json_encode($productRow->toArray()) }}"
                       name="{{ $nameField }}[{{ $rowIndex }}][product]" class="input-product">
                <a target="_blank"
                   href="{{ route('admin.products.edit', $productRow->id) }}">{{ $productRow->productName }}</a>
                <div>
                    <img src="{{ $productRow->imageUrl }}" alt="" width="128px">
                </div>
            @else
                <input type="hidden" data-id={{ $rowIndex }} value=""
                       name="{{ $nameField }}[{{ $rowIndex }}][product]" class="input-product">
                <a target="_blank" href="#"></a>
                <div>
                    <img src="" alt="" width="128px">
                </div>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="{{ $nameField }}[{{ $rowIndex }}][content]">{{ __('Product content review') }}</label>
        <textarea name="{{ $nameField }}[{{ $rowIndex }}][content]"
                  class="ckeditor">{{ $productRow->pivot->content ?? '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="{{ $nameField }}[{{ $rowIndex }}][image][]">{{ __('List image') }}</label>
        <input type="file" name="{{ $nameField }}[{{ $rowIndex }}][image][]" class="form-control" multiple>
        @php
            if (!empty($productRow) && !empty($productRow->pivot->images)) {
                $listImage = json_decode($productRow->pivot->images, true);
            }
        @endphp

        <div class="row align-items-center mt-2">
            @if(!empty($listImage) && count($listImage) > 0 && !empty($post) && !empty($post->id))
                @foreach($listImage as $image)
                    <div class="col">
                        <div class="text-center mb-1">
                            <button class="btn btn-danger btn-remove-image"
                                    data-is-remove="1"
                                    type="button">
                                <i class="fa fa-close"></i>
                            </button>
                            <input type="hidden"
                                   name="{{ $nameField }}[{{ $rowIndex }}][list_image_remove][{{ $image }}]"
                                   value="">
                        </div>
                        <img src="{{ asset('images_upload/post_images/' . $post->id . '/products/' . $image) }}"
                             width="100%">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
