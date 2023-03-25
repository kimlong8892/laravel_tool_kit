@if(!empty($field->id))
    <div class="form-group">
        <label>{{ __('ID') }}</label>
        <input type="text" class="form-control" value="{{ $field->id }}" readonly>
    </div>
@endif

{{--<div class="form-group">--}}
{{--    <label for="parent_id">{{ __('Parent field') }}</label>--}}
{{--    <select name="parent_id" class="form-control">--}}
{{--        <option value="">-</option>--}}
{{--        @foreach($listFied as $field)--}}
{{--            <option value="{{ $field->id }}">{{  }}</option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--    @include('admin.include.text_error_field', ['name' => 'parent_id'])--}}
{{--</div>--}}

<div class="form-group">
    <label for="name">{{ __('title') }} @include('admin.include.icon_required')</label>
    <input type="text"
           class="form-control"
           name="title"
           placeholder="{{ __('title') }}"
           value="{{ $field->name ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'title'])
</div>

<div class="form-group">
    <label for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
    <input type="text"
           class="form-control"
           name="name"
           placeholder="{{ __('Name') }}"
           value="{{ $field->name ?? '' }}">
    @include('admin.include.text_error_field', ['name' => 'name'])
</div>

<div class="form-group">
    <label for="name">{{ __('type') }} @include('admin.include.icon_required')</label>

    <select name="type" class="form-control" data-is-dependency="1" data-element-dependency="#values" data-value-dependency-on="select">
        <option value="">-</option>
        @foreach(config('custom.field')['type'] as $key => $value)
            <option
                @if(!empty($field) && $field->type == $key)
                    selected
                @endif
                value="{{ $key }}">
                {{ $value }}
            </option>
        @endforeach
    </select>
    @include('admin.include.text_error_field', ['name' => 'type'])
</div>


<div class="form-group" id="values">
    <label for="values">{{ __('Values') }} @include('admin.include.icon_required')</label>
    <select class="form-control select2" multiple="multiple" name="values[]">
        @if(!empty($field) && !empty($field->values))
            @foreach(explode(',', $field->values) as $field)
                <option selected value="{{ $field }}">{{ $field }}</option>
            @endforeach
        @endif
    </select>
    @include('admin.include.text_error_field', ['name' => 'tags'])
</div>

