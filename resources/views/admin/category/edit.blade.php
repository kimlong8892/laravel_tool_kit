@extends('layouts.admin')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Edit category') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', $category->name) }}">
                    @error('name')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Logo') }} @include('admin.include.icon_required')</label>
                    <div class="p-2">
                        <img src="{{ asset($category->logo) }}" alt="" id="logo-img-preview">
                    </div>
                    <input type="file" class="form-control" name="logo" id="logo">
                    @error('logo')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Campaign') }} @include('admin.include.icon_required')</label>

                    <select name="campaign_id" id="campaign_id" class="form-control form-select">
                        @foreach($listCampaign as $campaign)
                            <option value="{{ $campaign->id }}" @if($category->campaign_id == $campaign->id) selected @endif>{{ $campaign->name }}</option>
                        @endforeach
                    </select>
                    @error('campaign_id')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Enabled') }}</label>
                    <input type="checkbox" class="form-check-input" name="enabled" id="enabled" value="1" @if($category->enabled) checked @endif>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Type') }} @include('admin.include.icon_required')</label>
                    @php
                        $listCategoryType = config('custom.const.LIST_CATEGORY_TYPE');
                    @endphp

                    <select name="type" id="type" class="form-select">
                        @foreach($listCategoryType as $categoryType)
                            <option value="{{ $categoryType }}" @if($category->type == $categoryType) selected @endif>{{ $categoryType }}</option>
                        @endforeach
                    </select>

                    @error('type')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3" id="api_url_container">
                    <label class="form-label" for="name">{{ __('Api url') }}</label>
                    <input type="text" class="form-control" name="api_url" id="api_url" placeholder="{{ __('api_url') }}" value="{{ old('api_url', $category->api_url) }}">
                    @error('api_url')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('List coupon') }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="10%" class="text-center">{{ __('ID') }}</th>
                    <th width="10%" class="text-center">{{ __('Logo') }}</th>
                    <th width="25%" class="text-center">{{ __('Name') }}</th>
                    <th width="5%" class="text-center">{{ __('enabled') }}</th>
                    <th width="20%" class="text-center">{{ __('Action') }}</th>
                </tr>

                @if(!empty($category->Coupons) && count($category->Coupons) > 0)
                    @foreach($category->Coupons as $coupon)
                        <tr>
                            <td class="text-center">{{ $coupon->id }}</td>
                            <td class="text-center">
                                <img src="{{ asset($coupon->logo) }}" alt="" width="100%">
                            </td>
                            <td>{{ $coupon->name }}</td>
                            <td class="text-center">
                                @if($coupon->enabled)
                                    <i class="fa fa-check"></i>
                                @else
                                    <i class="fa fa-x"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                            {{ __('Edit') }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="7" class="text-center text-danger">{{ __('No record') }}</td>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#logo').change(function (event) {
                $("#logo-img-preview").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
    @include('admin.category._js')
@endsection
