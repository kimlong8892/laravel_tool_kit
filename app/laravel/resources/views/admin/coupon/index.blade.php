@extends('layouts.admin')

@section('content')
    <div class="text-right mb-5">
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fa fa-newspaper"></i>
            {{ __('Add new') }}
        </a>
    </div>

    <table class="table table-bordered">
        <form action="{{ route('admin.coupons.index') }}" method="GET">
            <tr>
                <th width="10%" class="text-center"></th>
                <th width="10%" class="text-center"></th>
                <th width="25%" class="text-center">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}"
                           value="{{ request()->get('name') ?? '' }}">
                </th>
                <th width="15%" class="text-center">
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="" readonly="">-</option>
                        @foreach($listCategory as $category)
                            <option value="{{ $category->id }}"
                                    @if(request()->get('category_id') == $category->id) selected @endif>{{ $category->name }} [{{ $category->Campaign->name }}]</option>
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
            <th width="15%" class="text-center">{{ __('Category') }}</th>
            <th width="5%" class="text-center">{{ __('enabled') }}</th>
            <th width="20%" class="text-center">{{ __('Action') }}</th>
        </tr>

        @if(!empty($listCoupon) && count($listCoupon) > 0)
            @foreach($listCoupon as $coupon)
                <tr>
                    <td class="text-center">{{ $coupon->id }}</td>
                    <td class="text-center">
                        <img src="{{ asset($coupon->logo) }}" alt="" width="100%">
                    </td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->Category->name }}</td>
                    <td class="text-center">
                        @if($coupon->enabled)
                            <i class="fa fa-check"></i>
                        @else
                            <i class="fa fa-x"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex">
                            <form class="p-2" action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                  method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>

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
@endsection
