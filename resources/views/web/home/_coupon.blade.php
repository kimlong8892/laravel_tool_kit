<div class="col-md-4 col-6">
    <div class="card mb-3 p-3">
        <div class="row">
            <div class="col-md-4">
                <img class="card-img card-img-left" src="{{ $coupon['logo'] ?? '' }}" alt="{{ $coupon['code'] ?? '' }}" width="100%">
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
                        {{ $coupon['code'] ?? $coupon['title'] ?? '' }}
                        @if(!empty($coupon['code']))
                            <button data-link="{{ $coupon['link'] ?? '' }}"
                                    data-coupon-code="{{ $coupon['code'] }}"
                                    class="btn btn-primary btn-copy-coupon-code btn-sm"><i class="fa fa-copy"></i>
                            </button>
                        @endif
                    </p>
                    <p class="card-text">
                        {{ $coupon['description'] ?? '' }}
                    </p>

                    @if(!empty($coupon['end_time']))
                        <p class="card-text">
                            <small class="text-muted">
                                @php
                                    $countDayEnd = getDayOfDateToDate($coupon['end_time']);
                                @endphp

                                @if($countDayEnd > 0)
                                    {{ __('date end') }}: {{ $coupon['end_time'] }} ({{ getDayOfDateToDate($coupon['end_time']) }} {{ __('day') }})
                                @elseif($countDayEnd == 0)
                                    {{ __('date end') }}: {{ $coupon['end_time'] }} {{ __('to day') }}
                                @else
                                    {{ __('date end') }}: {{ $coupon['end_time'] }} ({{ __('ended') }})
                                @endif
                            </small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
