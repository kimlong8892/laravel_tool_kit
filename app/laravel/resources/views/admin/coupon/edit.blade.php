@extends('layouts.admin')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Update coupon') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Name') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ old('name', $coupon->name) }}">
                    @error('name')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Code') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="{{ __('Code') }}" value="{{ old('code', $coupon->code) }}">
                    @error('code')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Link') }} @include('admin.include.icon_required')</label>
                    <input type="text" class="form-control" name="link" id="link" placeholder="{{ __('Link') }}" value="{{ old('link', $coupon->link) }}">
                    @error('link')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Description') }}</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('Description', $coupon->description) }}</textarea>
                    @error('description')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Start time') }}</label>
                    <input type="date" class="form-control" name="start_time" id="start_time" placeholder="{{ __('Start time') }}" value="{{ old('start_time', $coupon->start_time) }}">
                    @error('start_time')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('End time') }} @include('admin.include.icon_required')</label>
                    <input type="date" class="form-control" name="end_time" id="end_time" placeholder="{{ __('End time') }}" value="{{ old('end_time', $coupon->end_time) }}">
                    @error('end_time')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Logo') }} @include('admin.include.icon_required')</label>
                    <div class="p-2">
                        <img src="{{ asset($coupon->logo) }}" alt="" id="logo-img-preview">
                    </div>
                    <input type="file" class="form-control" name="logo" id="logo">
                    @error('logo')
                    <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Category') }} @include('admin.include.icon_required')</label>
                    <select name="category_id" id="category_id" class="form-control form-select">
                        @foreach($listCategory as $category)
                            <option value="{{ $category->id }}" @if($coupon->category_id == $category->id) selected @endif>{{ $category->name }} [{{ $category->Campaign->name }}]</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <font color="red">{{ $message }}</font>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="enabled">{{ __('Enabled') }}</label>
                    <input type="checkbox" class="form-check-input" name="enabled" id="enabled" value="1" @if($coupon->enabled) checked @endif>
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
