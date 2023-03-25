@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    @php
        $id = 1;
    @endphp
    <div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th colspan="2" nowrap>{{ __('Total Commission') }}</th>
                <th colspan="3" nowrap><h4 class="text-primary mt-0 mb-0 pt-0 pb-0">{{ formatVnd(array_sum(array_column($listConversionReport, 'totalCommission'))) }}</h4></th>
            </tr>
            <tr>
                <th width="5%" nowrap>{{ __('STT') }}</th>
                <th width="20%" nowrap>{{ __('Purchase Time') }}</th>
                <th width="65%" nowrap>{{ __('Item detail') }}</th>
                <th width="5%" nowrap>{{ __('Status') }}</th>
                <th width="5%" nowrap>{{ __('Total Commission') }}</th>
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
                                <tr>
                                    <th width="5%" nowrap>{{ __('STT') }}</th>
                                    <th width="55%" nowrap>{{ __('Item name') }}</th>
                                    <th width="10%" nowrap>{{ __('Item price') }}</th>
                                    <th width="10%" nowrap>{{ __('Item commission') }}</th>
                                    <th width="10%" nowrap>{{ __('Item qty') }}</th>
                                    <th width="10%" nowrap>{{ __('Item image') }}</th>
                                </tr>
                                @foreach($order['items'] as $item)
                                    <tr>
                                        <td width="5%">{{ $idProduct++ }}</td>
                                        <td width="55%">{{ $item['itemName'] ?? '' }}</td>
                                        <td width="10%" nowrap>{{ formatVnd($item['itemPrice'] ?? '') }}</td>
                                        <td width="10%">{{ formatVnd($item['itemCommission'] ?? '') }}</td>
                                        <td width="10%">{{ $item['qty'] ?? '' }}</td>
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
