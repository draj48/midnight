<h3 class="text-lg text-gray-700 dark:text-gray-200 font-medium mb-4 pb-4 border-b border-gray-100 dark:border-gray-800">{{__('Google')}}</h3>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="GOOGLE_CLIENT_ID" :value="__('Google Client ID')"/>
            <x-form.input id="GOOGLE_CLIENT_ID" name="GOOGLE_CLIENT_ID" type="text" class="mt-1 block w-full"
                          value="{{ old('GOOGLE_CLIENT_ID', env('GOOGLE_CLIENT_ID')) }}"
                          placeholder="{{__('Google Client ID')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="GOOGLE_CLIENT_SECRET" :value="__('Google Client Secret')"/>
            <x-form.input id="GOOGLE_CLIENT_SECRET" name="GOOGLE_CLIENT_SECRET" type="text" class="mt-1 block w-full"
                          value="{{ old('GOOGLE_CLIENT_SECRET', env('GOOGLE_CLIENT_SECRET')) }}"
                          placeholder="{{__('Google Client Secret')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="ANALYTICS_PROPERTY_ID" :value="__('Google View ID')"/>
            <x-form.input id="ANALYTICS_PROPERTY_ID" name="ANALYTICS_PROPERTY_ID" type="text" class="mt-1 block w-full"
                          value="{{ old('ANALYTICS_PROPERTY_ID', env('ANALYTICS_PROPERTY_ID')) }}"
                          placeholder="{{__('Google View ID')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="GOOGLE_P12" :value="__('Google JSON File')"/>
            <x-form.file id="GOOGLE_P12" name="GOOGLE_P12" type="file" class="mt-1 block w-full" placeholder="{{__('Google JSON File')}}"/>
        </div>
    </div>
</div>
<hr class="my-6 border-transparent">
<h3 class="text-lg text-gray-700 dark:text-gray-200 font-medium mb-4 pb-4 border-b border-gray-100 dark:border-gray-800">{{__('Onesignal')}}</h3>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="ONESIGNAL_APP_ID" :value="__('Onesignal ID')"/>
            <x-form.input id="ONESIGNAL_APP_ID" name="ONESIGNAL_APP_ID" type="text" class="mt-1 block w-full"
                          value="{{ old('ONESIGNAL_APP_ID', env('ONESIGNAL_APP_ID')) }}"
                          placeholder="{{__('Onesignal ID')}}"/>
        </div>
    </div>
    <div class="col-span-6">
        <div class="mb-5">
            <x-form.label for="ONESIGNAL_REST_API_KEY" :value="__('Onesignal Key')"/>
            <x-form.input id="ONESIGNAL_REST_API_KEY" name="ONESIGNAL_REST_API_KEY" type="text" class="mt-1 block w-full"
                          value="{{ old('ONESIGNAL_REST_API_KEY', env('ONESIGNAL_REST_API_KEY')) }}"
                          placeholder="{{__('Onesignal Key')}}"/>
        </div>
    </div>
</div>
