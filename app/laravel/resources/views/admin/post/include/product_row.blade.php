@php
    if (!isset($rowIndex)) {
         $rowIndex = time() . rand(1111, 99999) * rand(1111, 888888);
    }

    $nameField = 'product_row_insert';

    if (!empty($productRow)) {
        $nameField = 'product_row_update';
    }
@endphp

<div class="mt-4 card p-2">
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

{{--    <div class="form-group">--}}
{{--        <label for="{{ $nameField }}[{{ $rowIndex }}][product]">{{ __('Product') }}</label>--}}
{{--        <select class="form-control select2-one select2-product" name="{{ $nameField }}[{{ $rowIndex }}][product]">--}}
{{--            @if(!empty($productRow) && !empty($productRow->productName) && !empty($productRow->itemId))--}}
{{--                <option selected value="{{ $productRow->itemId }}">{{ $productRow->productName }}</option>--}}
{{--            @endif--}}
{{--        </select>--}}
{{--    </div>--}}

    <div class="form-group">
        <label for="{{ $nameField }}[{{ $rowIndex }}][content]">{{ __('Product content review') }}</label>
        <textarea name="{{ $nameField }}[{{ $rowIndex }}][content]" class="ckeditor">{{ $productRow->pivot->content ?? '' }}</textarea>
    </div>

    <div class="form-group">
        <label for="{{ $nameField }}[{{ $rowIndex }}][image][]">{{ __('List image') }}</label>
        <input type="file" name="{{ $nameField }}[{{ $rowIndex }}][image][]" class="form-control" multiple>
        @php
            if (!empty($productRow) && !empty($productRow->pivot->images)) {
                $listImage = json_decode($productRow->pivot->images, true);
            }
        @endphp

        <div class="row align-items-center">
            @if(!empty($listImage) && count($listImage) > 0 && !empty($post) && !empty($post->id))
                @foreach($listImage as $image)
                    <div class="col">
                        <img src="{{ asset('images_upload/post_images/' . $post->id . '/products/' . $image) }}" width="100%">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
