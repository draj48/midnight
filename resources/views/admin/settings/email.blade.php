<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
    <div class="col-span-12">
        <div class="mb-5">
            <x-form.label for="MAIL_HOST" :value="__('SMTP Host')"/>
            <x-form.input id="MAIL_HOST" name="MAIL_HOST" type="text" class="mt-1 block w-full"
                          value="{{ old('MAIL_HOST', env('MAIL_HOST')) }}"
                          placeholder="{{__('SMTP Host')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="MAIL_HOST" :value="__('SMTP Username')"/>
            <x-form.input id="MAIL_HOST" name="MAIL_USERNAME" type="text" class="mt-1 block w-full"
                          value="{{ old('MAIL_USERNAME', env('MAIL_USERNAME')) }}"
                          placeholder="{{__('SMTP Username')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="MAIL_PASSWORD" :value="__('SMTP Password')"/>
            <x-form.input id="MAIL_PASSWORD" name="MAIL_PASSWORD" type="text" class="mt-1 block w-full"
                          value="{{ old('MAIL_PASSWORD', env('MAIL_PASSWORD')) }}"
                          placeholder="{{__('SMTP Password')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="MAIL_PORT" :value="__('SMTP Port')"/>
            <x-form.input id="MAIL_PORT" name="MAIL_PORT" type="text" class="mt-1 block w-full"
                          value="{{ old('MAIL_PORT', env('MAIL_PORT')) }}"
                          placeholder="{{__('SMTP Port')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="MAIL_ENCRYPTION" :value="__('SMTP Encryption')"/>
            <x-form.select name="MAIL_ENCRYPTION">

                <option value="">{{__('Choose')}}</option>
                <option value="ssl" @if(env('MAIL_ENCRYPTION') == 'ssl') selected="true" @endif>SSL</option>
                <option value="tls" @if(env('MAIL_ENCRYPTION') == 'tls') selected="true" @endif>TLS</option>
            </x-form.select>
        </div>
    </div>
    <div class="col-span-12">
        <div class="mb-5">
            <x-form.label for="to_email" :value="__('Contact e-mail address')"/>
            <x-form.input id="to_email" name="to_email" type="text" class="mt-1 block w-full"
                          value="{{ old('to_email', config('settings.to_email')) }}"
                          placeholder="{{__('Contact e-mail address')}}"/>
        </div>
    </div>
</div>
