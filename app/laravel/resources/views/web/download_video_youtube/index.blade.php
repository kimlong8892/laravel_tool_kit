@extends('layouts.web')

@section('content')
    <form action="{{ route('web.download_video_youtube') }}" method="GET">
        <div class="form-group row">
            <div class="col-md-10 col-10">
                <input type="text" name="video_url" value="{{ request()->get('video_url') }}" class="form-control"
                       placeholder="{{ __('Enter video youtube url') }}">
                @error('video_url')
                <font color="red">{{ $message }}</font>
                @enderror
            </div>
            <div class="col-md-2 col-2">
                <button class="btn btn-primary">
                    <i class="fa fa-download"></i>
                    {{ __('Download') }}
                </button>
            </div>
        </div>
    </form>

    @if(!empty($listVideo))
        <table class="table table-bordered mt-3">
            <tr>
                <th>{{ __('mimeType') }}</th>
                <th>{{ __('Quality') }}</th>
                <th>{{ __('Download') }}</th>
            </tr>
            @foreach($listVideo as $video)
                @if(!empty($video->qualityLabel) && !empty($video->mimeType) && !empty($video->url))
                    <tr>
                        <td>{{ $video->mimeType }}</td>
                        <td>{{ $video->qualityLabel }}</td>
                        <td>
                            <a href="{{ $video->url }}" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ __('Download') }}
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>



    @endif
@endsection
