<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}">{{ $field->name }}</label>
    <input type="text" class="form-control" name="{{ renderNameCustomField($field) }}"
           placeholder="{{ $field->name }}" value="{{ $listFieldValue[$field->id] ?? '' }}">
</div>
