@extends('layouts.admin')

@section('content')
    <h1>{{ __('Get Conversion Report data') }}</h1>
    <h5>{{ __('Total Commission') }}: {{ formatVnd(array_sum(array_column($listConversionReport, 'totalCommission'))) }} </h5>
    @php
        $stt = 1;
    @endphp
    <div>
        <table class="table table-bordered">
            <tr>
                <td><b>{{ __('ID') }}</b></td>
                <td><b>{{ __('Purchase Time') }}</b></td>
                <td><b>{{ __('Item Detail') }}</b></td>
                <td><b>{{ __('Status') }}</b></td>
                <td><b>{{ __('Total Commission') }}</b></td>
            </tr>
            @foreach($listConversionReport as $conversionReport)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ date("Y-m-d H:i:s", $conversionReport['purchaseTime']) }}</td>
                    <td>
                        <table class="table table-bordered">
                            @foreach($conversionReport['orders'] as $order)
                                @foreach($order['items'] as $item)
                                    <tr>
                                        <td>{{ $item['itemName'] ?? '' }}</td>
                                        <td><b>{{ __('Item Price') }}:</b> {{ formatVnd($item['itemPrice'] ?? '') }}</td>
                                        <td><b>{{ __('Item Commission') }}:</b> {{ formatVnd($item['itemCommission'] ?? '') }}</td>
                                        <td><b>{{ __('Qty') }}:</b> {{ $item['qty'] ?? '' }}</td>
                                        <td>
                                            <img src="{{ $item['imageUrl'] ?? '' }}" alt="" width="30%">
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </td>
                    <td>{{ __($conversionReport['conversionStatus']) }}</td>
                    <td>{{ formatVnd($conversionReport['totalCommission']) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
