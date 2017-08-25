<div class="form-group">
    <label for="">Application Name:</label>
    <input type="text" name="name" class="form-control" value="{{ $application->name or '' }}">
    <div class="form-error" data-error="name"> {{ getFirstError($errors, 'name') }} </div>
</div>
<input type="hidden" name="fb_appid" value="{{ config('app.fb_appid') }}">
<input type="hidden" name="fb_appsecret" value="{{ config('app.fb_appsecret') }}">
<button type="submit" class="btn btn-primary">{{ $submitButton }}</button>