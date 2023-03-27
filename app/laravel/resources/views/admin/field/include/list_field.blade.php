@if(!empty($field->id))
    <div class="form-group">
        <label>{{ __('ID') }}</label>
        <input type="text" class="form-control" value="{{ $field->id }}" readonly>
    </div>
@endif

<div class="form-group">
    <label for="parent_id">{{ __('Parent field') }}</label>
    <select name="parent_id" class="form-control">
        <option value="">-</option>
        @include('admin.field.include.list_field_select', ['listField' => $listField, 'numberChar' => 0])
    </select>
    @include('admin.include.text_error_field', ['name' => 'parent_id'])
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
    <label for="entity">{{ __('Entity') }} @include('admin.include.icon_required')</label>

    <select name="entity" class="form-control">
        <option value="">-</option>
        @foreach(config('custom.field')['entity'] as $key => $value)
            <option
                @if(!empty($field) && $field->entity == $key)
                    selected
                @endif
                value="{{ $key }}">
                {{ $value }}
            </option>
        @endforeach
    </select>
    @include('admin.include.text_error_field', ['name' => 'entity'])
</div>


<div class="form-group">
    <label for="type">{{ __('type') }} @include('admin.include.icon_required')</label>

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
            @if(is_array(json_decode($field->values, true)))
                @foreach(json_decode($field->values, true) as $field)
                    <option selected value="{{ $field }}">{{ $field }}</option>
                @endforeach
            @endif
        @endif
    </select>
    @include('admin.include.text_error_field', ['name' => 'tags'])
</div>
