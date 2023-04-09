@extends('layouts.admin')

@section('title', __('List post'))

@section('content')
    <div class="text-right mb-2">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            {{ __('Create') }}
        </a>
    </div>

    <div>
        {{ $listPost->appends(request()->input())->links() }}
    </div>

    <table class="table table-bordered table-responsive">
        <tr>
            <th width="5%">{{ __('ID') }}</th>
            <th width="25%">{{ __('Name') }}</th>
            <th width="10%">{{ __('Image') }}</th>
            <th width="15%">{{ __('Description') }}</th>
            <th width="10%">{{ __('Author') }}</th>
            <th width="10%">{{ __('Status') }}</th>
            <th width="10%">{{ __('View') }}</th>
            <th width="15%">{{ __('Action') }}</th>
        </tr>

        @if(!empty($listPost) && count($listPost) > 0)
            @foreach($listPost as $item)
            <tr>
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    <img src="{{ $item->getImage() }}" width="100%">
                </td>
                <td>{{ $item->description }}</td>
                <td class="text-center">
                    <span
                        @if(!empty($item->Admin->id) && $item->Admin->id == getCurrentAdminId())
                            class="alert alert-success text-black font-weight-bold"
                        @endif>
                        {{ $item->Admin->name ?? '' }}
                    </span>
                </td>
                <td>{{ $item->status }}</td>
                <td class="text-center">{{ $item->view ?? 0 }}</td>
                <td class="text-center">
                    <div class="mb-2">
                        <a href="{{ route('admin.posts.edit', $item->id) }}"
                           class="btn btn-primary"
                        >
                            <i class="fa fa-edit"></i>
                            {{ __('Edit') }}
                        </a>
                    </div>

                    <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                            {{ __('Delete') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center text-danger">{{ __('No record') }}</td>
            </tr>
        @endif
    </table>

    <div>
        {{ $listPost->appends(request()->input())->links() }}
    </div>
@endsection
