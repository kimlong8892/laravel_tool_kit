<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}">{{ $field->name }}</label>
    <textarea name="{{ renderNameCustomField($field) }}" class="ckeditor">{{ $listFieldValue[$field->id] ?? '' }}</textarea>
</div>
