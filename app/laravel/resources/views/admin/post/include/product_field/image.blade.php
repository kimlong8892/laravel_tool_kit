<div class="form-group">
    <label for="{{ renderNameCustomField($field) }}[]">{{ $field->name }}</label>
    <input type="file" class="form-control" name="{{ renderNameCustomField($field) }}[]"
           multiple="multiple"
           placeholder="{{ $field->name }}">
    <div class="mt-2">
        @php
            $listImage = json_decode($listFieldValue[$field->id] ?? '', true);

            if (!is_array($listImage)) {
                $listImage = [$listImage];
            }
        @endphp


        <div class="row align-items-center">
            @foreach($listImage as $imagePreview)
                <div class="mt-2 col">
                    <img src="{{ getImageCustomField($imagePreview, $field->id) }}" width="100%">
                </div>
            @endforeach
        </div>
    </div>
</div>
