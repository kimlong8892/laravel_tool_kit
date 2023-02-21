<table class="table table-light">
    <thead>
    <tr>
        <th width="20%">{{ __('coupon code') }}</th>
        <th width="40%">{{ __('coupon desc') }}</th>
        <th width="20%">{{ __('end time') }}</th>
        <th width="10%">{{ __('image') }}</th>
        <th width="10%">{{ __('link') }}</th>
    </tr>
    </thead>
    <tbody class="table-border-bottom-0">
    @if(!empty($listCoupon['data']))
        @foreach($listCoupon['data'] as $coupon)
            <tr>
                <td>
                    {{ $coupon['coupons'][0]['coupon_code'] ?? '' }}
                    <button data-link="{{ $coupon['link'] ?? '' }}" data-coupon-code="{{ $coupon['coupons'][0]['coupon_code'] ?? '' }}" class="btn btn-primary btn-copy-coupon-code"><i class="fa fa-copy"></i></button>
                </td>
                <td>{{ $coupon['coupons'][0]['coupon_desc'] ?? '' }}</td>
                <td>
                    {{ $coupon['end_time'] ?? '' }}
                </td>
                <td>
                    <img src="{{ $coupon['image'] ?? '' }}" width="100%">
                </td>
                <td>
                    <a href="{{ $coupon['link'] ?? '' }}">{{ __('Detail') }}</a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center text-danger">{{ __('No record coupon') }}</td>
        </tr>
    @endif

    </tbody>
</table>
