<div class="col-md-3 col-6 col-lg-2 mb-2">
    <a href="{{ route('web.post.detail', ['slug' => $item->slug]) }}">
        <div class="card p-2">
            <img src="{{ $item->getImage() }}" width="100%">
            <h5 class="mt-0 mb-0 text-center p-2">{{ $item->name }}</h5>
        </div>
    </a>
</div>
