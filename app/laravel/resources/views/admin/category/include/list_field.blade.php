@if(!empty($category->id))
    <div class="form-group">
        <label>{{ __('ID') }}</label>
        <input type="text" class="form-control" value="{{ $category->id }}" readonly>
    </div>
@endif

<div class="form-group">
    <label for="parent_id">{{ __('Parent category') }}</label>
    <select name="parent_id" class="form-control">
        <option value="">-</option>
        @include('admin.category.include.list_category_select', ['listCategory' => $listCategory, 'numberChar' => 0])
    </select>
    @include('admin.include.text_error_field', ['name' => 'parent_id'])
</div>

<div class="form-group">
    <label for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
    <input type="text"
           @if(empty($category))
               data-is-gen-slug="1"
           @endif
           data-input-slug-id="slug"
           class="form-control"
           name="name"
           placeholder="{{ __('name') }}"
           value="{{ $category->name ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'name'])
</div>

<div class="form-group">
    <label for="slug">{{ __('Slug') }} @include('admin.include.icon_required')</label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="{{ __('Slug') }}" value="{{ $category->slug ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'slug'])
</div>

<div class="form-group">
    <label for="image">{{ __('Image') }} @include('admin.include.icon_required')</label>
    <input type="file" class="form-control" name="image" data-id="image">
    <div class="mt-2">
        <img src="{{ !empty($category) ? ($category->getImage() ?? '') : '' }}" id="image-preview" width="100%">
    </div>
    @include('admin.include.text_error_field', ['name' => 'image'])
</div>

<div class="form-group">
    <label for="name">{{ __('Description') }} @include('admin.include.icon_required')</label>
    <textarea name="description" cols="30" rows="10" class="form-control">{{ $category->description ?? '' }}</textarea>
    @include('admin.include.text_error_field', ['name' => 'description'])
</div>
