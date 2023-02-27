@if(!empty($listCategory) && count($listCategory) > 0)
    <p class="mt-2">{{ __('Category') }}</p>
    @foreach($listCategory as $category)
        <div class="col text-white mb-2 nowrap">
            @php
                $requestHref = request()->toArray();
                $requestHref['category_id'] = $category->id;

                if (!empty($requestHref['page'])) {
                     $requestHref['page'] = 1;
                }
            @endphp
            <a
                href="{{ route('web.home', $requestHref) }}"
                @if($category->id == request()->get('category_id'))
                    class="btn rounded-pill btn-primary w-100"
                @else
                    class="btn rounded-pill btn-secondary w-100"
                @endif
            >
                <img src="{{ asset($category->logo) }}" width="32px" class="rounded-circle" style="height: 32px;">
                {{ $category->name }}
            </a>
        </div>
    @endforeach
@else
    <p class="mt-2 text-danger text-center">{{ __('List category not found') }}</p>
@endif
