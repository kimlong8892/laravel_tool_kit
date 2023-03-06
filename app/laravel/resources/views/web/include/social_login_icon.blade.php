@if(!empty($iconOnly))
    <a href="{{ route('web.social.redirect', ['social' => 'google']) }}" class="btn btn-danger me-2"><i
            class="fa-brands fa-google"></i> Google</a>
    <a href="{{ route('web.social.redirect', ['social' => 'github']) }}" class="btn btn-dark me-2"><i
            class="fa-brands fa-github"></i> Github</a>
@else
    <div class="form-group row mt-2 align-items-center">
        <label class="col-md-4 col-form-label text-md-right">{{ __('login with social') }}</label>
        <div class="col-md-6">
            <a href="{{ route('web.social.redirect', ['social' => 'google']) }}" class="btn btn-danger mt-2"><i
                    class="fa-brands fa-google"></i> Google</a>
            <a href="{{ route('web.social.redirect', ['social' => 'github']) }}" class="btn btn-dark mt-2"><i
                    class="fa-brands fa-github"></i> Github</a>
        </div>
    </div>
@endif
