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
            @include('admin.category.include.tr_header')
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
