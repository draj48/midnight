<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10 gap-y-2">
    <div class="lg:col-span-12">
        <div class="mb-5">
            <x-form.label for="site_name" :value="__('Site name')"/>
            <x-form.input id="site_name" name="site_name" type="text" class="mt-1 block w-full"
                          value="{{ old('site_name', config('settings.site_name')) }}"
                          placeholder="{{__('Site name')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('site_name')"/>
        </div>
    </div>
    <div class="lg:col-span-12">
        <div class="mb-5">
            <x-form.label for="site_about" :value="__('Site about')"/>
            <x-form.input id="site_about" name="site_about" type="text" class="mt-1 block w-full"
                          value="{{ old('site_about', config('settings.site_about')) }}"
                          placeholder="{{__('Site about')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('site_about')"/>
        </div>
    </div>
    <div class="lg:col-span-12">
        <div class="mb-5">
            <x-form.label for="language" :value="__('Language')"/>
            <x-form.select name="language">
                @foreach($languages as $language)
                    <option value="{{$language->code}}" @if(config('settings.language') == $language->code)
                        {{'selected'}}
                        @endif>{{$language->name}}</option>
                @endforeach
            </x-form.select>
        </div>
    </div>
    <div class="lg:col-span-6">
        <div class="mb-5">
            <x-form.label for="logo" :value="__('Logo')"/>
            <x-form.file id="logo" name="logo" type="file" class="mt-1 block w-full" placeholder="{{__('logo')}}"/>
        </div>
    </div>
    <div class="lg:col-span-6">
        <div class="mb-5">
            <x-form.label for="favicon" :value="__('Favicon')"/>
            <x-form.file id="favicon" name="favicon" type="file" class="mt-1 block w-full"
                         placeholder="{{__('Favicon')}}"/>
        </div>
    </div>
    <div class="lg:col-span-12">
        <hr class="my-6 border-gray-100 dark:border-gray-800">
    </div>
    <div class="lg:col-span-12">
        <div class="mb-5">
            <x-form.label for="custom_code" :value="__('Custom code')"/>
            <x-form.textarea name="custom_code"
                             placeholder="{{__('Custom code')}}">{{old('custom_code', config('settings.custom_code'))}}</x-form.textarea>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="preloader" :value="__('Preloader video play')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="preloader" name="preloader" value="active"
                               :checked="config('settings.preloader') == 'active' ? true : false"/>
                <x-form.label for="preloader" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Enable Preloader video play')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="comment" :value="__('Comments')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="comment" name="comment" value="active"
                               :checked="config('settings.comment') == 'active' ? true : false"/>
                <x-form.label for="comment" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Closed comment')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="request_status" :value="__('Request')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="request_status" name="request_status" value="active"
                               :checked="config('settings.request_status') == 'active' ? true : false"/>
                <x-form.label for="request_status" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Active request')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="request_member" :value="__('Request is for members only')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="request_member" name="request_member" value="active"
                               :checked="config('settings.request_member') == 'active' ? true : false"/>
                <x-form.label for="request_member" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Request is for members only')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="subscription" :value="__('Subscription')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="subscription" name="subscription" value="active"
                               :checked="config('settings.subscription') == 'active' ? true : false"/>
                <x-form.label for="subscription" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Enable subscription')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="landing" :value="__('Landing')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="landing" name="landing" value="active"
                               :checked="config('settings.landing') == 'active' ? true : false"/>
                <x-form.label for="landing" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Enable landing page')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="comment_status" :value="__('Comment status')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="comment_status" name="comment_status" value="active"
                               :checked="config('settings.comment_status') == 'active' ? true : false"/>
                <x-form.label for="comment_status" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Approve comments')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="history" :value="__('Watch history')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="history" name="history" value="active"
                               :checked="config('settings.history') == 'active' ? true : false"/>
                <x-form.label for="history" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Save watch history')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="user_register" :value="__('Registration')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="register" name="register" value="disable"
                               :checked="config('settings.register') == 'disable' ? true : false"/>
                <x-form.label for="register" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Disable user registration')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="cookie" :value="__('Cookie Policy')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="cookie" name="cookie" value="active"
                               :checked="config('settings.cookie') == 'active' ? true : false"/>
                <x-form.label for="cookie" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Show Cookie Policy')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="sidenav_featured" :value="__('Sidenav featured')"/>
            <div class="flex items-center space-x-4">
                <x-form.switch type="checkbox" id="sidenav_featured" name="sidenav_featured" value="active"
                               :checked="config('settings.sidenav_featured') == 'active' ? true : false"/>
                <x-form.label for="sidenav_featured" class="lg:mb-0 cursor-pointer font-normal"
                              :value="__('Show featured from Sidenav')"/>
            </div>
        </div>
    </div>
    <div class="lg:col-span-12">
        <hr class="my-6 border-gray-100 dark:border-gray-800">
    </div>
    <div class="lg:col-span-12">
        <div class="mb-5">
            <x-form.label for="player" :value="__('Player')"/>
            <x-form.select name="player">
                <option value="plyr" @if(config('settings.player') == 'plyr')
                    {{'selected'}}
                    @endif>{{__('Plyr.io')}}</option>
                <option value="videojs" @if(config('settings.player') == 'videojs')
                    {{'selected'}}
                    @endif>{{__('Videojs')}}</option>
            </x-form.select>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="terms_url" :value="__('Terms of service URL')"/>
            <x-form.input id="terms_url" name="terms_url" type="text" class="mt-1 block w-full"
                          value="{{ old('terms_url', config('settings.terms_url')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('terms_url')"/>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="privacy_url" :value="__('Privacy policy URL')"/>
            <x-form.input id="privacy_url" name="privacy_url" type="text" class="mt-1 block w-full"
                          value="{{ old('privacy_url', config('settings.privacy_url')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('privacy_url')"/>
        </div>
    </div>
    <div class="lg:col-span-4">
        <div class="mb-5">
            <x-form.label for="cookie_url" :value="__('Cookie policy URL')"/>
            <x-form.input id="cookie_url" name="cookie_url" type="text" class="mt-1 block w-full"
                          value="{{ old('cookie_url', config('settings.cookie_url')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('cookie_url')"/>
        </div>
    </div>

    <div class="lg:col-span-12">
        <hr class="my-6 border-gray-100 dark:border-gray-800">
    </div>
    <div class="lg:col-span-6">
        <div class="mb-5">
            <x-form.label for="promote_text" :value="__('Promote text')"/>
            <x-form.input id="promote_text" name="promote_text" type="text" class="mt-1 block w-full"
                          value="{{ old('promote_text', config('settings.promote_text')) }}"
                          placeholder="{{__('Promote text')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('promote_text')"/>
        </div>
    </div>

    <div class="lg:col-span-6">
        <div class="mb-5">
            <x-form.label for="promote_link" :value="__('Promote link')"/>
            <x-form.input id="promote_link" name="promote_link" type="text" class="mt-1 block w-full"
                          value="{{ old('promote_link', config('settings.promote_link')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('promote_link')"/>
        </div>
    </div>

    <div class="lg:col-span-12">
        <hr class="my-6 border-gray-100 dark:border-gray-800">
    </div>
    <div class="lg:col-span-3">
        <div class="mb-5">
            <x-form.label for="facebook" :value="__('Facebook')"/>
            <x-form.input id="facebook" name="facebook" type="text" class="mt-1 block w-full"
                          value="{{ old('facebook', config('settings.facebook')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('facebook')"/>
        </div>
    </div>
    <div class="lg:col-span-3">
        <div class="mb-5">
            <x-form.label for="twitter" :value="__('Twitter')"/>
            <x-form.input id="twitter" name="twitter" type="text" class="mt-1 block w-full"
                          value="{{ old('twitter', config('settings.twitter')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('twitter')"/>
        </div>
    </div>
    <div class="lg:col-span-3">
        <div class="mb-5">
            <x-form.label for="instagram" :value="__('Instagram')"/>
            <x-form.input id="instagram" name="instagram" type="text" class="mt-1 block w-full"
                          value="{{ old('instagram', config('settings.instagram')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('instagram')"/>
        </div>
    </div>
    <div class="lg:col-span-3">
        <div class="mb-5">
            <x-form.label for="youtube" :value="__('Youtube')"/>
            <x-form.input id="youtube" name="youtube" type="text" class="mt-1 block w-full"
                          value="{{ old('youtube', config('settings.youtube')) }}"
                          placeholder="{{__('https://')}}"/>
            <x-form.error class="mt-2" :messages="$errors->get('youtube')"/>
        </div>
    </div>
</div>

<div class="mb-5">
    <x-form.label for="footer_description" :value="__('Footer description')"/>
    <x-form.textarea name="footer_description"
                     id="footer_description"
                     class="settings-editor">{!! old('footer_description', config('settings.footer_description'))  !!}</x-form.textarea>
</div>

<div class="mb-5">
    <x-form.label for="landing_title" :value="__('Landing title')"/>
    <x-form.input id="landing_title" name="landing_title" type="text" class="mt-1 block w-full"
                  value="{{ old('landing_title', config('settings.landing_title')) }}"
                  placeholder="{{__('Landing title')}}"/>
</div>
<div class="mb-5">
    <x-form.label for="landing_description" :value="__('Landing description')"/>
    <x-form.input id="landing_description" name="landing_description" type="text" class="mt-1 block w-full"
                  value="{{ old('landing_description', config('settings.landing_description')) }}"
                  placeholder="{{__('Landing description')}}"/>
</div>
<div class="mb-5">
    <x-form.label for="landing_body" :value="__('Landing about')"/>
    <x-form.textarea name="landing_body"
                     id="landing_body"
                     class="settings-editor">{!! old('landing_body', config('settings.landing_body'))  !!}</x-form.textarea>
</div>
