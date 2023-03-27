@if(!empty($listField) && count($listField) > 0)
    <div class="card p-3 mt-5">
        <h4 class="mb-0 pb-0 text-uppercase font-weight-bold">{{ __('List field custom for post') }}</h4>
        @foreach($listField as $field)
            <div class="mt-2">
                @include('admin.post.include.product_field.' . $field->type, compact('field'))
            </div>
        @endforeach
    </div>
@endif
