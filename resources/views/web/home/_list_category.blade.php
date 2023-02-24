@if(!empty($listCategory) && count($listCategory) > 0)
    @foreach($listCategory as $category)
        <div class="p-2 col-md-3">
            <button class="btn btn-primary bg-white text-dark bg w-100 d-flex align-items-center" style="text-align: left !important;">
                <img src="{{ asset($category->logo) }}" width="40px" style="height: 40px">
                <span class="pl-2">{{ $category->name }}</span>
            </button>
        </div>
    @endforeach
@endif
