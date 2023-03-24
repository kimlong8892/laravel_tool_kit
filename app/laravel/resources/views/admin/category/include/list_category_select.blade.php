@foreach($listCategory as $categoryItem)
    @if(empty($category) || $categoryItem->id != $category->id)
        <option
            @if(!empty($category) && $category->parent_id == $categoryItem->id)
                selected
            @endif
            value="{{ $categoryItem->id }}">
            @for($i = 0; $i < $numberChar; ++$i) ____ @endfor
            {{ $categoryItem->name }}
        </option>

        @if(!empty($categoryItem->ChildCategories) && count($categoryItem->ChildCategories) > 0)
            @php
                if (isset($numberChar)) {
                     $numberChar++;
                }
            @endphp
            @include('admin.category.include.list_category_select', ['listCategory' => $categoryItem->ChildCategories, 'numberChar' => $numberChar])
        @endif
    @endif
@endforeach
