@extends('layouts.admin')

@section('title', __('List category'))

@section('content')
    <div class="text-right mb-2">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            {{ __('Create') }}
        </a>
    </div>
    <div>
        {{ $listCategory->appends(request()->input())->links() }}
    </div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th width="5%">{{ __('ID') }}</th>
            <th width="75%">{{ __('Name') }}</th>
            <th width="10%">{{ __('Image') }}</th>
            <th width="10%">{{ __('Action') }}</th>
        </tr>

        @if(!empty($listCategory) && count($listCategory) > 0)
            @include('admin.category.include.list_category_index', ['listCategory' => $listCategory])
        @else
            <tr>
                <td colspan="4" class="text-center text-danger">{{ __('No record') }}</td>
            </tr>
        @endif
    </table>
    <div>
        {{ $listCategory->appends(request()->input())->links() }}
    </div>
@endsection
