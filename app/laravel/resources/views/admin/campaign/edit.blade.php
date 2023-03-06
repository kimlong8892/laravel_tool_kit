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
                    <label class="form-label" for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', $campaign->name) }}">
                    @error('name')
                        <font color="red">{{ $message }}</font>
                    @enderror
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

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('List category') }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center" width="10%">{{ __('ID') }}</th>
                    <th class="text-center" width="20%">{{ __('Logo') }}</th>
                    <th class="text-center" width="30%">{{ __('Name') }}</th>
                    <th class="text-center" width="20%">{{ __('Is accesstrade') }}</th>
                    <th class="text-center" width="5%">{{ __('Enabled') }}</th>
                    <th class="text-center" width="15%">{{ __('Action') }}</th>
                </tr>
                @if(!empty($campaign->Categories) && count($campaign->Categories) > 0)
                    @foreach ($campaign->Categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td>
                        <td class="text-center"><img src="{{ asset($category->logo) }}" alt="" width="100%"></td>
                        <td class="text-center">{{ $category->name }}</td>
                        <td>
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
                        <td>
                            <div class="d-flex">
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
                    <tr>
                        <td colspan="6" class="text-center text-danger">{{ __('No record') }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Accesstrade info') }}</h5>
        </div>
        <div class="card-body">
            @foreach($campaign->toArray() as $key => $value)
                @if(!empty(explode('_', $key)[0]) && explode('_', $key)[0] == 'accesstrade')
                    <div class="mb-3">
                        <label class="form-label" for="name">{{ __($key) }}</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="{{ __($key) }}" value="{{ $value }}" disabled>
                    </div>
                @endif
            @endforeach
        </div>
    </div>



@endsection
