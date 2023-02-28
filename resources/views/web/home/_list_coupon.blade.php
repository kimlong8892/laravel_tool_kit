@if(!empty($listCoupon['data']))
    <div class="row mb-3">
        @if(!empty($page) && $page > 1)
            <div class="col">
                @php
                    $requestHref = request()->toArray();
                    if (!empty($requestHref['page'])) {
                         $requestHref['page'] = $requestHref['page'] - 1;
                    }
                @endphp

                <a href="{{ route('web.home', $requestHref) }}" class="btn btn-primary" type="button">
                    <i class="fa fa-arrow-left"></i>
                    {{ __('previous') }}
                </a>
            </div>
        @endif
        <div class="col" style="text-align: right;">
            @php
                $requestHref = request()->toArray();
                if (!empty($requestHref['page'])) {
                     $requestHref['page'] = $requestHref['page'] + 1;
                } else {
                    $requestHref['page'] = 2;
                }
            @endphp
            <a href="{{ route('web.home', $requestHref) }}" class="btn btn-primary" type="button">
                {{ __('next') }}
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
@endif

<div class="row row-unique">
    @if(!empty($listCoupon['data']))
        @foreach($listCoupon['data'] as $coupon)
            @php
                $coupon = [
                    'logo' => $coupon['image'] ?? '',
                    'link' => $coupon['link'],
                    'code' => $coupon['coupons'][0]['coupon_code'],
                    'description' => $coupon['coupons'][0]['coupon_desc'],
                    'end_time' => $coupon['end_time']
                ];
            @endphp

            @include('web.home._coupon', ['coupon' => $coupon])
        @endforeach
    @else
        @if($page == 1)
            <div class="col-md-12 col-12">
                <p class="text-danger text-center">{{ __('No record coupon') }}</p>
            </div>
        @endif
    @endif
</div>
