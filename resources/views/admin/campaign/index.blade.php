@extends('layouts.admin')

@section('content')
    <div class="text-right mb-5">
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
            <i class="fa fa-newspaper"></i>
            {{ __('Add new') }}
        </a>

        <form action="{{ route('admin.update-info-campaigns-accesstrade') }}" method="POST" class="mt-3">
            @csrf
            <button class="btn btn-warning">{{ __('updateInfoCampaignsAccesstrade') }}</button>
        </form>
    </div>

    <table class="table table-bordered">
        <tr>
            <th width="10%" class="text-center">{{ __('ID') }}</th>
            <th width="10%" class="text-center">{{ __('Logo') }}</th>
            <th width="55%" class="text-center">{{ __('Name') }}</th>
            <th width="5%" class="text-center">{{ __('enabled') }}</th>
            <th width="20%" class="text-center">{{ __('Action') }}</th>
        </tr>

        @if(!empty($listCampaign) && count($listCampaign) > 0)
            @foreach($listCampaign as $campaign)
            <tr>
                <td class="text-center">{{ $campaign->id }}</td>
                <td class="text-center">
                    <img src="{{ $campaign->accesstrade_logo }}" alt="" width="100%">
                </td>
                <td>{{ $campaign->name }}</td>
                <td class="text-center">
                    @if($campaign->enabled)
                        <i class="fa fa-check"></i>
                    @else
                        <i class="fa fa-x"></i>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex">
                        <form class="p-2" action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                                {{ __('Delete') }}
                            </button>
                        </form>

                        <div class="p-2">
                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                                {{ __('Edit') }}
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        @else
            <td colspan="5" class="text-center text-danger">{{ __('No record') }}</td>
        @endif
    </table>
@endsection
