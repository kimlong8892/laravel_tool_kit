<div class="form-group">
    <label for="status">{{ __('Status') }} @include('admin.include.icon_required')</label>
    <select name="status" class="form-select">
        @foreach(config('custom.post')['status'] ?? [] as $status)
            <option
                value="{{ $status }}"
                @if(!empty($product->status) && $product->status == $status)
                    selected
                @endif
            >
                {{ __($status) }}
            </option>
        @endforeach
    </select>
    @include('admin.include.text_error_field', ['name' => 'status'])
</div>

@if(isset($listCategory))
    <div class="form-group">
        @foreach($listCategory as $category)
            <label for="category_id">{{ $category->name }}</label>
            <input type="checkbox" name="category_id" value="{{ $category->id }}">
        @endforeach
    </div>
@endif
