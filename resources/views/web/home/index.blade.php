@extends('layouts.web')

@section('content')
    @include('web.include.breadcrumb', ['text' => __('List coupon')])

    <style>
        .table-content-coupon {
            max-height: 65vh !important;
            overflow: auto;
        }
    </style>

    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            @foreach($listCampaign as $item)
                <li class="nav-item">
                    <button
                        data-merchant="{{ $item->merchant }}"
                        type="button"
                        class="nav-link btn-merchant"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-{{ $item->id }}"
                        aria-controls="navs-pills-{{ $item->id }}"
                        aria-selected="true"
                    >
                        <img src="{{ $item->logo }}" width="64px" alt="{{ $item->name_custom }}"> {{ $item->name_custom }}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($listCampaign as $item)
                <div class="tab-pane fade table-content-coupon" id="navs-pills-{{ $item->id }}" role="tabpanel"></div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-merchant', function () {
                let merchant = $(this).attr('data-merchant');
                let id = $(this).attr('data-id');
                let idString = $(this).attr('data-bs-target');
                let html = $(idString).html().trim();

                if (html === '') {
                    $.ajax({
                        url: @json(route('web.ajax.get_list_coupon')),
                        data: {
                            merchant: merchant
                        },
                        success: function (html) {
                            console.log(html);
                            $(idString).html(html);
                        }
                    });
                }
            });

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
