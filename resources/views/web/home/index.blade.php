@extends('layouts.web')

@section('title', __('List coupon'))

@section('content')
    @include('web.include.breadcrumb', ['text' => __('List coupon')])

    <p class="mt-2">{{ __('Campaign') }}</p>
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

    <div class="row">
        @include('web.home._list_category')
    </div>

    <div class="mt-5" id="list-coupon">
        @if($isAccesstrade)
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
                        <i class="fa fa-arrow-right"></i>
                        {{ __('next') }}
                    </a>
                </div>
            </div>
            @include('web.home._list_coupon')
        @else
            <div class="row">
                @foreach($listCoupon as $coupon)
                    <div class="col">
                        <div class="card mb-3 p-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="card-img card-img-left" src="{{ asset($coupon->logo) }}" alt="Card image">
                                    <div class="text-center mt-2 mb-2">
                                        <a href="#" target="_blank" class="btn btn-warning p-1 m-0">
                                            <i class="fa fa-info-circle"></i>
                                            {{ __('view detail') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <p class="card-title">
                                            {{ $coupon->code ?? '' }}
                                            <button class="btn btn-primary btn-copy-coupon-code btn-sm"><i class="fa fa-copy"></i>
                                            </button>
                                        </p>
                                        <p class="card-text">
                                            {{ $coupon->description }}
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                {{ __('date end') }}: {{ $coupon->end_time }} ({{ getDayOfDateToDate($coupon->end_time) }} {{ __('day') }})
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
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
