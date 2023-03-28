@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    @php
        $id = 1;
    @endphp
    <div class="fixed-table-div" style="height: 80vh">
        <table class="table table-bordered table-responsive table-fixed">
            <tr>
                <th width="5%" nowrap>{{ __('STT') }}</th>
                <th width="20%" nowrap>{{ __('Purchase Time') }}</th>
                <th width="65%">
                    <table cellspacing="0px" width="100%">
                        <tr>
                            <th width="10%" class="text-center">{{ __('STT') }}</th>
                            <th width="35%" class="text-center">{{ __('Item name') }}</th>
                            <th width="15%" class="text-center">{{ __('Item price') }}</th>
                            <th width="15%" class="text-center">{{ __('Item commission') }}</th>
                            <th width="15%" class="text-center">{{ __('Item qty') }}</th>
                            <th width="10%" class="text-center">{{ __('Item image') }}</th>
                        </tr>
                    </table>
                </th>
                <th width="5%" nowrap>{{ __('Status') }}</th>
                <th width="5%" nowrap>{{ __('Total Commission') }}: {{ formatVnd(array_sum(array_column($listConversionReport, 'totalCommission'))) }}</th>
            </tr>
            @foreach($listConversionReport as $conversionReport)
                <tr>
                    <td width="5%">{{ $id++ }}</td>
                    <td width="20%">{{ date("Y-m-d H:i:s", $conversionReport['purchaseTime']) }}</td>
                    <td width="65%">
                        <table cellspacing="0px" class="table table-bordered" width="100%">
                            @php
                                $idProduct = 1;
                            @endphp

                            @foreach($conversionReport['orders'] as $order)
                                @foreach($order['items'] as $item)
                                    <tr>
                                        <td width="10%">{{ $idProduct++ }}</td>
                                        <td width="35%">{{ $item['itemName'] ?? '' }}</td>
                                        <td width="15%">{{ formatVnd($item['itemPrice'] ?? '', false) }}</td>
                                        <td width="15%">{{ formatVnd($item['itemCommission'] ?? '', false) }}</td>
                                        <td width="15%">{{ $item['qty'] ?? '' }}</td>
                                        <td width="10%">
                                            <img src="{{ $item['imageUrl'] ?? '' }}" alt="" width="100%">
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </td>
                    <td width="5%">{{ __($conversionReport['conversionStatus']) }}</td>
                    <td width="5%">{{ formatVnd($conversionReport['totalCommission']) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
