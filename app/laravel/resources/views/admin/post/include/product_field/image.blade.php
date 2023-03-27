<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}">{{ $field->name }}</label>
    <input type="file" class="form-control" name="{{ renderNameCustomField($field) }}"
           placeholder="{{ $field->name }}" data-id="image-custom-field-{{ $field->id }}">
    <div class="mt-2">
        <img src="{{ getImageCustomField($listFieldValue[$field->id] ?? '', $field->id) }}"
             id="image-custom-field-{{ $field->id }}-preview">
    </div>
</div>
