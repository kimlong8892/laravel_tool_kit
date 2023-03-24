<div class="form-group">
    <label for="status">{{ __('Status') }} @include('admin.include.icon_required')</label>
    <select name="status" class="form-select">
        @foreach(config('custom.post')['status'] ?? [] as $status)
            <option
                value="{{ $status }}"
                @if(!empty($post->status) && $post->status == $status)
                    selected
                @endif
            >
                {{ __($status) }}
            </option>
        @endforeach
    </select>
    @include('admin.include.text_error_field', ['name' => 'status'])
</div>

<div class="card p-2 mt-2">
    <label>{{ __('Categories') }} @include('admin.include.icon_required')</label>
    <div style="height: 300px; overflow: auto;" class="mb-2 p-4 pt-0">
        @include('admin.post.include.list_category', compact('listCategory'))
    </div>
    @include('admin.include.text_error_field', ['name' => 'category_id'])
</div>

<div class="form-group">
    <select class="form-control select2" multiple="multiple" name="tags[]">
        @foreach($listTag as $tag)
            <option @if(!empty($post) && !empty($post->getTagIds()[$tag->id])) selected @endif value="{{ $tag->name }}">{{ $tag->name }}</option>
        @endforeach
    </select>

    @include('admin.include.text_error_field', ['name' => 'tags'])
</div>
