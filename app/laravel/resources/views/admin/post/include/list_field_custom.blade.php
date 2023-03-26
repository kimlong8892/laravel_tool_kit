@if(!empty($listField) && count($listField) > 0)
    @foreach($listField as $field)
        @if($field->type == 'flexible')
            <div class="form-group">
                <div class="text-right">
                    <button class="btn btn-primary btn-flexible w-100" data-div-id="#div-flexible-{{ $field->id }}"
                            type="button">
                        <i class="fa fa-plus-circle"></i>
                        {{ __('Add row') }} [{{ $field->title }}]
                    </button>
                </div>
            </div>

            <div class="form-group" id="div-flexible-{{ $field->id }}">
            </div>
        @elseif($field->type == 'text')
            <div class="form-group">
                <label for="custom_field[{{ $field->name }}]">{{ $field->title }}</label>
                <input type="text" class="form-control" name="custom_field[{{ $field->name }}]"
                       placeholder="{{ $field->title }}">
            </div>
        @elseif($field->type == 'wysiwyg')
            <label for="custom_field[{{ $field->name }}]">{{ $field->title }}</label>
            <textarea name="custom_field[{{ $field->name }}]" class="ckeditor"></textarea>
        @endif
    @endforeach
@endif
