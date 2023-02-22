@if($page == 1)
    <div class="row row-unique">
@endif
    @if(!empty($listCoupon['data']))
        @foreach($listCoupon['data'] as $coupon)
            <div class="col-md-4 col-6">
                <div class="card mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="card-img card-img-left" src="{{ $coupon['image'] ?? '' }}" alt="Card image">
                            <div class="text-center mt-2 mb-2">
                                <a href="{{ $coupon['link'] }}" target="_blank" class="btn btn-warning p-1 m-0">
                                    <i class="fa fa-info-circle"></i>
                                    {{ __('view detail') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <p class="card-title">
                                    {{ $coupon['coupons'][0]['coupon_code'] ?? '' }}
                                    <button data-link="{{ $coupon['link'] ?? '' }}"
                                            data-coupon-code="{{ $coupon['coupons'][0]['coupon_code'] ?? '' }}"
                                            class="btn btn-primary btn-copy-coupon-code btn-sm"><i class="fa fa-copy"></i>
                                    </button>
                                </p>
                                <p class="card-text">
                                    {{ $coupon['coupons'][0]['coupon_desc'] ?? '' }}
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        {{ __('date end') }}: {{ $coupon['end_time'] }} ({{ getDayOfDateToDate($coupon['end_time']) }} {{ __('day') }})
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @if($page == 1)
            <div class="col-md-12 col-12">
                <p class="text-danger text-center">{{ __('No record coupon') }}</p>
            </div>
        @endif
    @endif
@if($page == 1)
    </div>
@endif

