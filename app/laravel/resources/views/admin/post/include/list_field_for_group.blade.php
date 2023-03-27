<div class="border p-3">
    @foreach($listField as $field)
        @include('admin.post.include.product_field.' . $field->type, compact('field'))
    @endforeach
</div>
