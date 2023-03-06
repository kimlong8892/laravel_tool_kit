<div class="container-captcha">
    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
</div>
<div>
    @if($errors->has('g-recaptcha-response'))
        <div class="text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
    @elseif($errors->has('captcha'))
        <div class="text-danger">{{ $errors->first('captcha') }}</div>
    @endif
</div>
