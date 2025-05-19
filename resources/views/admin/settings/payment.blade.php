{{--payment--}}
<div
    class="rounded-lg border shadow-sm border-gray-200 dark:border-gray-800 dark:bg-gray-900 px-5 divide-y divide-gray-100 mb-2">
    <div class="" x-data="{ expanded: {{config('settings.paypal') == 'active' ? 'true' : 'false'}} }">
        <div class="py-5 px-1 font-medium text-gray-500 flex items-center space-x-4">
            <x-form.switch type="checkbox" id="paypal" name="paypal" value="active"
                           :checked="config('settings.paypal') == 'active' ? true : false"
                           @change="expanded = ! expanded"/>
            <span class="flex-1">Paypal</span>
        </div>
        <div x-show="expanded" x-collapse>
            <div class="px-1 py-5 border-t border-gray-100 dark:border-gray-800">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="paypal_mode" :value="__('Mode')"/>
                            <x-form.select name="paypal_mode">
                                <option value="live" @if(config('settings.paypal_mode') == 'live')
                                    {{'selected'}}
                                    @endif>Live
                                </option>
                                <option value="sandbox" @if(config('settings.paypal_mode') == 'sandbox')
                                    {{'selected'}}
                                    @endif>Sandbox
                                </option>
                            </x-form.select>
                            <x-form.error class="mt-2" :messages="$errors->get('site_name')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="paypal_client_id" :value="__('Client ID')"/>
                            <x-form.input id="paypal_client_id" name="paypal_client_id" type="text"
                                          class="mt-1 block w-full"
                                          value="{{ old('paypal_client_id', config('settings.paypal_client_id')) }}"
                                          placeholder="{{__('Client ID')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('paypal_client_id')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="paypal_secret" :value="__('Secret')"/>
                            <x-form.input id="paypal_secret" name="paypal_secret" type="text" class="mt-1 block w-full"
                                          value="{{ old('paypal_secret', config('settings.paypal_secret')) }}"
                                          placeholder="{{__('Secret')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('paypal_secret')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="paypal_webhook_id" :value="__('Webhook ID')"/>
                            <x-form.input id="paypal_webhook_id" name="paypal_webhook_id" type="text"
                                          class="mt-1 block w-full"
                                          value="{{ old('paypal_webhook_id', config('settings.paypal_webhook_id')) }}"
                                          placeholder="{{__('Webhook ID')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('paypal_webhook_id')"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--payment--}}
{{--payment--}}
<div
    class="rounded-lg border shadow-sm border-gray-200 dark:border-gray-800 dark:bg-gray-900 px-5 divide-y divide-gray-100 mb-2">
    <div class="" x-data="{ expanded: {{config('settings.stripe') == 'active' ? 'true' : 'false'}} }">
        <div class="py-5 px-1 font-medium text-gray-500 flex items-center space-x-4 js-handle">
            <x-form.switch type="checkbox" id="stripe" name="stripe" value="active"
                           :checked="config('settings.stripe') == 'active' ? true : false"
                           @change="expanded = ! expanded"/>
            <span class="flex-1">Stripe</span>
        </div>
        <div x-show="expanded" x-collapse>
            <div class="px-1 py-5 border-t border-gray-100 dark:border-gray-800">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="stripe_mode" :value="__('Mode')"/>
                            <x-form.select name="stripe_mode">
                                <option value="live" @if(config('settings.stripe_mode') == 'live'){{'selected'}}@endif>Live</option>
                                <option value="sandbox" @if(config('settings.stripe_mode') == 'sandbox'){{'selected'}}@endif>Sandbox</option>
                            </x-form.select>
                            <x-form.error class="mt-2" :messages="$errors->get('stripe_mode')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="stripe_key" :value="__('Publishable key')"/>
                            <x-form.input id="stripe_key" name="stripe_key" type="text" class="mt-1 block w-full"
                                          value="{{ old('stripe_key', config('settings.stripe_key')) }}"
                                          placeholder="{{__('Publishable key')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('stripe_key')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="stripe_secret_key" :value="__('Secret key')"/>
                            <x-form.input id="stripe_secret_key" name="stripe_secret_key" type="text" class="mt-1 block w-full"
                                          value="{{ old('stripe_secret_key', config('settings.stripe_secret_key')) }}"
                                          placeholder="{{__('Secret key')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('stripe_secret_key')"/>
                        </div>
                    </div>
                    <div class="lg:col-span-6">
                        <div class="mb-5">
                            <x-form.label for="stripe_signing_secret" :value="__('Signing secret')"/>
                            <x-form.input id="stripe_signing_secret" name="stripe_signing_secret" type="text" class="mt-1 block w-full"
                                          value="{{ old('stripe_signing_secret', config('settings.stripe_signing_secret')) }}"
                                          placeholder="{{__('Signing secret')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('stripe_signing_secret')"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--payment--}}

{{--payment--}}
<div
    class="rounded-lg border shadow-sm border-gray-200 dark:border-gray-800 dark:bg-gray-900 px-5 divide-y divide-gray-100 mb-4">
    <div class="" x-data="{ expanded: {{config('settings.bank') == 'active' ? 'true' : 'false'}} }">
        <div class="py-5 px-1 font-medium text-gray-500 flex items-center space-x-4 js-handle">
            <x-form.switch type="checkbox" id="bank" name="bank" value="active"
                           :checked="config('settings.bank') == 'active' ? true : false"
                           @change="expanded = ! expanded"/>
            <span class="flex-1">Bank transfer</span>
        </div>
        <div x-show="expanded" x-collapse>
            <div class="px-1 py-5 border-t border-gray-100 dark:border-gray-800">


                <div class="mb-5">
                    <x-form.label for="bank_detail" :value="__('Bank transfer detail')"/>
                    <x-form.textarea name="bank_detail"
                                     id="bank_detail" class="settings-editor">{!! old('bank_detail', config('settings.bank_detail'))  !!}</x-form.textarea>
                </div>
            </div>
        </div>
    </div>
</div>
{{--payment--}}
