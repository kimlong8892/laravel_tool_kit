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
                    <label class="form-label" for="enabled">{{ __('Is accesstrade') }}</label>
                    <input type="checkbox" class="form-check-input" name="is_accesstrade" id="is_accesstrade" value="1" @if($category->is_accesstrade) checked @endif>
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
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#logo').change(function (event) {
                $("#logo-img-preview").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@endsection
