<form action="{{ route('web.search_product') }}" method="GET" class="mt-5">
    <div class="form-group d-flex align-items-center">
        <div class="col-md-10 col-sm-11">
            <input type="text" class="form-control" name="q" value="{{ request()->get('q') ?? '' }}"
                   placeholder="{{ __('Enter search product') }}">
        </div>
        <div class="col-md-2 col-sm-1">
            <button class="btn btn-primary">
                <i class="fa fa-search"></i>
                {{ __('Search') }}
            </button>
        </div>
    </div>
</form>
