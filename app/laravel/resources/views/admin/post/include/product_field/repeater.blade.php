<div class="form-group">
    <p class="mt-0 mb-0 pt-0 pb-0">{{ $field->name }}</p>
    <div class="text-right">
        <button class="btn btn-primary btn-repeater w-100" data-div-id="#div-repeater-{{ $field->id }}"
                data-id="{{ $field->id }}"
                type="button">
            <i class="fa fa-plus-circle"></i>
            {{ __('Add row') }}
        </button>
    </div>
</div>

<div class="form-group" id="div-repeater-{{ $field->id }}">
</div>
