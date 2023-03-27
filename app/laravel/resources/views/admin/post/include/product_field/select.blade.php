<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}[]">{{ $field->name }}</label>
    <select class="form-control select2 @if(!empty($field->is_select_product)) select2-product @endif" multiple="multiple"
            name="{{ renderNameCustomField($field) }}[]" data-is-tags="{{ $field->is_select_product ?? '0' }}">
        @if((!empty($field) && !empty($field->values)))
            @if(!empty($field->is_select_product))
                @php
                    $fieldValues = renderProductSelectValues($listFieldValue[$field->id] ?? '');
                @endphp

                @if(!empty($fieldValues) && count($fieldValues) > 0)
                    @foreach($fieldValues as $fieldValue)
                        <option selected value="{{ $fieldValue->itemId }}">{{ $fieldValue->productName }} [{{ formatVnd($fieldValue->price, false) }}]</option>
                    @endforeach
                @endif
            @else
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
        @endif
    </select>
</div>
