<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}">{{ $field->name }}</label>
    <input type="checkbox" name="{{ renderNameCustomField($field) }}"
           @if(!empty($listFieldValue[$field->id]))
               checked
           @endif
           placeholder="{{ $field->name }}" value="1">
</div>
