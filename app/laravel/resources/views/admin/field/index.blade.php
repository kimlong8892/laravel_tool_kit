@extends('layouts.admin')

@section('title', __('List field'))

@section('content')
    <div class="text-right mb-2">
        <a href="{{ route('admin.fields.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            {{ __('Create') }}
        </a>
    </div>
    <div>
        {{ $listField->appends(request()->input())->links() }}
    </div>
    <table class="table table-bordered mt-2">
        <tr>
            @include('admin.field.include.tr_header')
        </tr>

        @if(!empty($listField) && count($listField) > 0)
            @include('admin.field.include.list_field_index', ['listField' => $listField])
        @else
            <tr>
                <td colspan="5" class="text-center text-danger">{{ __('No record') }}</td>
            </tr>
        @endif
    </table>
    <div>
        {{ $listField->appends(request()->input())->links() }}
    </div>
@endsection
