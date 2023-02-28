@extends('layouts.web')

@section('title', __('List coupon'))

@section('content')
    @include('web.include.breadcrumb', ['text' => __('List coupon')])
    <p class="mt-2 mb-0 fw-bold text-uppercase">{{ __('Campaign') }}</p>
    <div class="row">
        @foreach($listCampaign as $campaign)
            <div class="col">
                <a href="{{ route('web.home', ['merchant' => $campaign->accesstrade_merchant]) }}"
                    data-merchant="{{ $campaign->accesstrade_merchant }}"
                    @if($campaign->accesstrade_merchant == request()->get('merchant'))
                        class="btn rounded-pill btn-primary w-100 btn-merchant"
                    @else
                       class="btn rounded-pill btn-secondary w-100 btn-merchant"
                    @endif
                >
                    <img src="{{ $campaign->accesstrade_logo }}" width="40px" alt="{{ $campaign->name }}" class="rounded-circle">
                    {{ $campaign->name }}
                </a>
            </div>
        @endforeach
    </div>

    @if(!empty(request()->get('merchant')))
        <div class="row">
            @include('web.home._list_category')
        </div>
    @endif

    @if(!empty(request()->get('merchant')) && !empty(request()->get('category_id')))
        <div class="mt-5" id="list-coupon">
            @if($isAccesstrade)
                @include('web.home._list_coupon')
            @else
                @if(!empty($listCoupon) && $listCoupon->total() > 0)
                    <div>
                        {{ $listCoupon->appends(request()->input())->links() }}
                    </div>
                    <div class="row">
                        @foreach($listCoupon as $coupon)
                            @php
                                $coupon->logo = asset($coupon->logo);
                            @endphp
                            @include('web.home._coupon', ['coupon' => $coupon->toArray()])
                        @endforeach
                    </div>
                @else
                    <p class="text-danger text-center">{{ __('No record coupon') }}</p>
                @endif
            @endif
        </div>
    @endif
@endsection

@section('js')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick/slick.css') }}"/>
    <script src="{{ asset('lib/slick/slick.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-copy-coupon-code', function () {
                let code = $(this).attr('data-coupon-code');
                let $temp = $("<input>");
                $("body").append($temp);
                $temp.val(code).select();
                document.execCommand("copy");
                $temp.remove();

                Swal.fire(
                    @json(__('Copy success')),
                    code,
                    'success'
                );

                window.open($(this).attr('data-link'), '_blank');
            });
        });
    </script>
@endsection
