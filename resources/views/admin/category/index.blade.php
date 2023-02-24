@extends('layouts.admin')

@section('content')
    <div class="text-right mb-5">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fa fa-newspaper"></i>
            {{ __('Add new') }}
        </a>
    </div>

    <table class="table table-bordered">
        <form action="{{ route('admin.categories.index') }}" method="GET">
            <tr>
                <th width="10%" class="text-center"></th>
                <th width="10%" class="text-center"></th>
                <th width="25%" class="text-center">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}"
                           value="{{ request()->get('name') ?? '' }}">
                </th>
                <th width="15%" class="text-center">
                    <select name="campaign_id" id="campaign_id" class="form-select">
                        <option value="" readonly="">-</option>
                        @foreach($listCampaign as $campaign)
                            <option value="{{ $campaign->id }}"
                                    @if(request()->get('campaign_id') == $campaign->id) selected @endif>{{ $campaign->name }}</option>
                        @endforeach
                    </select>
                </th>
                <th width="40%" colspan="3">
                    <button class="btn btn-primary">
                        <i class="fa fa-search"></i>
                        {{ __('Search') }}
                    </button>
                </th>
            </tr>
        </form>

        <tr>
            <th width="10%" class="text-center">{{ __('ID') }}</th>
            <th width="10%" class="text-center">{{ __('Logo') }}</th>
            <th width="25%" class="text-center">{{ __('Name') }}</th>
            <th width="15%" class="text-center">{{ __('Campaign') }}</th>
            <th width="15%" class="text-center">{{ __('Is accesstrade') }}</th>
            <th width="5%" class="text-center">{{ __('enabled') }}</th>
            <th width="20%" class="text-center">{{ __('Action') }}</th>
        </tr>

        @if(!empty($listCategory) && count($listCategory) > 0)
            @foreach($listCategory as $category)
                <tr>
                    <td class="text-center">{{ $category->id }}</td>
                    <td class="text-center">
                        <img src="{{ asset($category->logo) }}" alt="" width="100%">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->Campaign->name }}</td>
                    <td class="text-center">
                        @if($category->is_accesstrade)
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-x"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($category->enabled)
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-x"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex">
                            <form class="p-2" action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>

                            <div class="p-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                                    <i class="fa fa-edit"></i>
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="6" class="text-center text-danger">{{ __('No record') }}</td>
        @endif
    </table>
@endsection
