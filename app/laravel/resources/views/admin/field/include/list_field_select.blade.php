@foreach($listField as $fieldItem)
    @if((empty($field) || $fieldItem->id != $field->id) && ($fieldItem->type == 'group' || $fieldItem->type == 'flexible'))
        <option
            @if(!empty($field) && $field->parent_id == $fieldItem->id)
                selected
            @endif
            value="{{ $fieldItem->id }}">
            @for($i = 0; $i < $numberChar; ++$i) ____ @endfor
            {{ $fieldItem->name }}
        </option>

        @if(!empty($fieldItem->ChildFields) && count($fieldItem->ChildFields) > 0)
            @php
                if (isset($numberChar)) {
                     $numberChar++;
                }
            @endphp
            @include('admin.field.include.list_field_select', ['listField' => $fieldItem->ChildFields, 'numberChar' => $numberChar])
        @endif
    @endif
@endforeach
