@if(!empty($post->id))
    <div class="form-group">
        <label>{{ __('ID') }}</label>
        <input type="text" class="form-control" value="{{ $post->id }}" readonly>
    </div>
@endif

<div class="form-group">
    <label for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
    <input type="text"
           @if(empty($post))
                data-is-gen-slug="1"
           @endif
           data-input-slug-id="slug"
           class="form-control"
           name="name"
           placeholder="{{ __('name') }}"
           value="{{ $post->name ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'name'])
</div>

<div class="form-group">
    <label for="slug">{{ __('Slug') }} @include('admin.include.icon_required')</label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="{{ __('Slug') }}" value="{{ $post->slug ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'slug'])
</div>

<div class="form-group">
    <label for="name">{{ __('Content') }} @include('admin.include.icon_required')</label>
    <textarea name="content" id="content" class="ckeditor">{{ $post->content ?? '' }}</textarea>
    @include('admin.include.text_error_field', ['name' => 'content'])
</div>
<div class="form-group">
    <button class="btn btn-primary w-100" id="btn-add-product-row" type="button">
        <i class="fa fa-plus-circle"></i>
        {{ __('Add row product') }}
    </button>

    <div id="div-product-row">
        @if(!empty($post) && !empty($post->Products) && count($post->Products))
            @foreach($post->Products as $key => $productRow)
                @include('admin.post.include.product_row', ['productRow' => $productRow, 'post' => $post, 'rowIndex' => $key])
            @endforeach
        @endif
    </div>
</div>
