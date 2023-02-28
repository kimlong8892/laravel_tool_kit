@extends('layouts.admin')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Create category') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', '') }}">
                    @error('name')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Logo') }} @include('admin.include.icon_required')</label>
                    <div class="p-2">
                        <img src="" alt="" id="logo-img-preview">
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
                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                        @endforeach
                    </select>
                    @error('campaign_id')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Enabled') }}</label>
                    <input type="checkbox" class="form-check-input" name="enabled" id="enabled" value="1">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Type') }} @include('admin.include.icon_required')</label>
                    @php
                        $listCategoryType = config('custom.const.LIST_CATEGORY_TYPE');
                    @endphp

                    <select name="type" id="type" class="form-select">
                        @foreach($listCategoryType as $categoryType)
                            <option value="{{ $categoryType }}">{{ $categoryType }}</option>
                        @endforeach
                    </select>

                    @error('type')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3" id="api_url_container">
                    <label class="form-label" for="name">{{ __('Api url') }}</label>
                    <input type="text" class="form-control" name="api_url" id="api_url" placeholder="{{ __('api_url') }}" value="{{ old('api_url', '') }}">
                    @error('api_url')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        {{ __('Create') }}
                    </button>
                </div>
            </form>
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
