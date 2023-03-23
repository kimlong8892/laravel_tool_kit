@if(isset($listCategory))
    @foreach($listCategory as $category)
        <div class="form-group">
            <span>{{ $category->name }}</span>
            @if(count($category->ChildCategories) == 0)
                <input
                    @if(!empty($post) && in_array($category->id, $post->Categories->pluck('id')->toArray()))
                        checked
                    @endif
                    type="checkbox"
                    name="category_id[]"
                    value="{{ $category->id }}"
                >
            @endif
        </div>

        @if(!empty($category->ChildCategories) && count($category->ChildCategories) > 0)
            <div class="ml-2">
                @include('admin.post.include.list_category', ['listCategory' => $category->ChildCategories])
            </div>
        @endif
    @endforeach
@endif
