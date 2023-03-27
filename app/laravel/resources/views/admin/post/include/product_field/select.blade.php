<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}[]">{{ $field->name }}</label>
    <select class="form-control select2" multiple="multiple" name="{{ renderNameCustomField($field) }}[]" data-is-tags="0">
        @if(!empty($field) && !empty($field->values))
            @if(is_array(json_decode($field->values, true)))
                @foreach(json_decode($field->values, true) as $fieldValue)
                    <option
                        @if(!empty($listFieldValue[$field->id]) && in_array($fieldValue, json_decode($listFieldValue[$field->id] ?? '', true)))
                            selected
                        @endif
                        value="{{ $fieldValue }}">
                        {{ $fieldValue }}
                    </option>
                @endforeach
            @endif
        @endif
    </select>
</div>
