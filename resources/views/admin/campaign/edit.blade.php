@extends('layouts.admin')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Edit campaign') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ $campaign->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Enabled') }}</label>
                    <input type="checkbox" class="form-check-input" name="enabled" id="enabled" value="1" @if($campaign->enabled) checked @endif>
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
