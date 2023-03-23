@if(!empty($post->id))
    <div class="form-group">
        <label>{{ __('ID') }}</label>
        <input type="text" class="form-control" value="{{ $post->id }}" readonly>
    </div>
@endif

<div class="form-group">
    <label for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
    <input type="text"
           data-is-gen-slug="1"
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
    <label for="image">{{ __('Image') }} @include('admin.include.icon_required')</label>
    <input type="file" class="form-control" name="image" data-id="image">
    <div class="mt-2">
        <img src="{{ !empty($post) ? ($post->getImage() ?? '') : '' }}" id="image-preview">
    </div>
    @include('admin.include.text_error_field', ['name' => 'image'])
</div>

<div class="form-group">
    <label for="name">{{ __('Description') }} @include('admin.include.icon_required')</label>
    <textarea name="description" cols="30" rows="10" class="form-control">{{ $post->description ?? '' }}</textarea>
    @include('admin.include.text_error_field', ['name' => 'description'])
</div>

<div class="form-group">
    <label for="name">{{ __('Content') }} @include('admin.include.icon_required')</label>
    <textarea name="content" id="content" class="ckeditor">{{ $post->content ?? '' }}</textarea>
    @include('admin.include.text_error_field', ['name' => 'content'])
</div>
