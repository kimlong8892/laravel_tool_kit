@extends('layouts.admin')

@section('title', __('Create post'))

@section('content')
    <form action="{{ route('admin.posts.store') }}" method="POST" id="form-main">
        @csrf

        <div class="row">
            <div class="col-10">
                @include('admin.post.include.list_fied_left')
            </div>
            <div class="col-2">
                @include('admin.post.include.list_field_right')

                <div class="form-group mt-3">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-save"></i>
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>


    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#form-main').submit(function (event) {
                event.preventDefault();
                let formData = new FormData(document.getElementById($(this).attr('id')));

                console.log(formData);

                $.LoadingOverlay('show');

                axios.post($(this).attr('action'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    if (response.data.success) {
                        window.location.replace(response.data.url);
                    }
                }).catch(function (err) {
                    let mess_errors = err.response.data.errors;
                    let scroll_flag = false;
                    $.LoadingOverlay('hide');

                    Object.keys(mess_errors).forEach(function (key) {
                        if (!scroll_flag) {
                            scroll_flag = true;

                            document.getElementById(`${key}-error`).scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }

                        $(`#${key}-error`).text(mess_errors[key]);
                    });
                });
            });
        });
    </script>
@endsection
