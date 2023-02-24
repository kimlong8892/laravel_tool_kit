@extends('layouts.web')

@section('title', __('List coupon'))

@section('content')
    @include('web.include.breadcrumb', ['text' => __('List coupon')])

    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            @foreach($listCampaign as $item)
                <li class="nav-item">
                    <button
                        data-merchant="{{ $item->accesstrade_merchant }}"
                        data-id="{{ $item->id }}"
                        type="button"
                        class="nav-link btn-merchant text-uppercase"
                        role="tab"
                        data-page="1"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-{{ $item->id }}"
                        aria-controls="navs-pills-{{ $item->id }}"
                        aria-selected="true"
                    >
                        <img src="{{ $item->accesstrade_logo }}" width="64px" alt="{{ $item->name }}"> {{ $item->name }}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($listCampaign as $item)
                <div class="tab-pane fade table-content-coupon" id="navs-pills-{{ $item->id }}" role="tabpanel"></div>
            @endforeach
            <div id="list-category" class="row"></div>
        </div>
    </div>


@endsection

@section('js')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick/slick.css') }}"/>
    <script src="{{ asset('lib/slick/slick.js') }}"></script>

    <script>
        $(document).ready(function () {
            let merchant = getParam('merchant');

            if (merchant === '' || merchant === 'undefined' || merchant === null) {
                merchant = @json(!empty($listCampaign[0]) ? $listCampaign[0]->accesstrade_merchant : '');
            }

            if (merchant !== '') {
                let btnClick = $(`.btn-merchant[data-merchant=${merchant}]`);
                btnClick.click();
                clickMerchant(btnClick);
            }

            $(document).on('click', '.btn-merchant', function () {
                clickMerchant($(this));
            });

            function clickMerchant(element) {
                merchant = element.attr('data-merchant');
                setQueryStringParameter('merchant', merchant);
                let idString = element.attr('data-bs-target');
                let html = $(idString).html();
                html = html.trim();
                let page = parseInt(element.attr('data-page'));
                let id = element.attr('data-id');


                $.LoadingOverlay('show');
                $.ajax({
                    url: @json(route('web.ajax.get_list_category_by_campaign_id')),
                    data: {
                        campaign_id: id,
                    },
                    success: function (html) {
                        $('#list-category').html(html);
                        $.LoadingOverlay('hide');
                    }
                });

                {{--if (html === '' || page !== 1) {--}}
                {{--    $.LoadingOverlay('show');--}}
                {{--    $.ajax({--}}
                {{--        url: @json(route('web.ajax.get_list_coupon')),--}}
                {{--        data: {--}}
                {{--            merchant: merchant,--}}
                {{--            page: page--}}
                {{--        },--}}
                {{--        success: function (html) {--}}
                {{--            if (page === 1) {--}}
                {{--                $(idString).html(html);--}}
                {{--            } else {--}}
                {{--                $(idString + " .row-unique").append(html);--}}
                {{--            }--}}

                {{--            $.LoadingOverlay('hide');--}}
                {{--        }--}}
                {{--    });--}}
                {{--}--}}
            }

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



            // window.onscroll = function(ev) {
            //     if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            //         let selector = `.btn-merchant[data-merchant='${merchant}']`;
            //         let currentPage = parseInt($(selector).attr('data-page'));
            //         $(selector).attr('data-page', ++currentPage);
            //         clickMerchant($(selector));
            //     }
            // };



        });
    </script>
@endsection
