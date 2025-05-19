@extends('layouts.app')
@section('content')

    <div class="py-4 max-w-5xl mx-auto lg:py-8">

        <form method="post" enctype="multipart/form-data">
            @csrf

            <div>
                <div class="flex items-center justify-center mb-5"
                     x-data="imageViewer('{{isset(Auth::user()->cover) ? asset(config('attr.avatar.path').Auth::user()->cover) : ''}}')">
                    <label for="cover-file"
                           class="flex flex-col items-center justify-center w-full aspect-[5/1] rounded-xl cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:hover:border-gray-500 dark:hover:bg-gray-900 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500"/>
                        </div>
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-[5/1] absolute inset-0 rounded-xl"
                            >
                        </template>
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-[5/1] absolute inset-0 rounded-xl"
                            ></div>
                        </template>
                        <input name="cover" id="cover-file" type="file" class="hidden" accept="image/*"
                               @change="fileChosen">
                    </label>
                </div>
                <div class="flex items-center justify-center w-32 h-32 mb-5 -mt-16 ml-4"
                     x-data="imageViewer('{{isset(Auth::user()->avatar) ? asset(config('attr.avatar.path').Auth::user()->avatar) : ''}}')">
                    <label for="avatar-file"
                           class="flex flex-col items-center justify-center w-full aspect-square border-4 border-gray-300 rounded-full cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-950 dark:hover:bg-gray-900 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500"/>
                        </div>
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-square absolute inset-0 rounded-full"
                            >
                        </template>
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-square absolute inset-0 rounded-full"
                            ></div>
                        </template>
                        <input name="avatar" id="avatar-file" type="file" class="hidden" accept="image/*"
                               @change="fileChosen">
                    </label>
                </div>
            </div>

            <div class="mb-4">

                <x-form.label for="name" :value="__('Name')"/>
                <x-form.input id="name" name="name" type="text" class="mt-1 block w-full"
                              :value="old('name', Auth::user()->name)" required autocomplete="name"/>
                <x-form.error class="mt-2" :messages="$errors->get('name')"/>
            </div>
            <div class="mb-4">
                <x-form.label for="email" :value="__('Email')"/>
                <x-form.input id="email" name="email" type="email" class="mt-1 block w-full"
                              :value="old('email', Auth::user()->email)" required autocomplete="email"/>
                <x-form.error class="mt-2" :messages="$errors->get('email')"/>
            </div>
            <div class="mb-4">
                <x-form.label for="username" :value="__('Username')"/>
                <x-form.input id="username" name="username" type="text" class="mt-1 block w-full"
                              :value="old('username', Auth::user()->username)" required autocomplete="username"
                              placeholder="{{__('Username')}}"/>
                <x-form.error class="mt-2" :messages="$errors->get('username')"/>
            </div>
            <div class="mb-4">
                <x-form.label for="about" :value="__('About')"/>
                <x-form.input id="about" name="about" type="text" class="mt-1 block w-full"
                              :value="old('about', Auth::user()->about)"
                              placeholder="{{__('About')}}"/>
                <x-form.error class="mt-2" :messages="$errors->get('about')"/>
            </div>
            <hr class="my-6 lg:my-10 border-gray-100 dark:border-gray-800">
            <h3 class="dark:text-white text-xl font-medium mb-4">{{__('Change password')}}</h3>
            <div class="mb-4">
                <x-form.label for="password" :value="__('Current password')"/>
                <x-form.input id="password" name="password" type="password" class="mt-1 block w-full"
                              autocomplete="password" placeholder="{{__('Current password')}}"/>
                <x-form.error class="mt-2" :messages="$errors->get('password')"/>
            </div>
            <div class="mb-4">
                <x-form.label for="new_password" :value="__('New password')"/>
                <x-form.input id="new_password" name="new_password" type="password" class="mt-1 block w-full"
                              autocomplete="password" placeholder="{{__('New password')}}"/>
                <x-form.error class="mt-2" :messages="$errors->get('new_password')"/>
            </div>
            <x-form.primary class="w-full max-w-xs mt-5">{{__('Save change')}}</x-form.primary>
        </form>
    </div>

    <script>

        function imageViewer(src = '') {
            return {
                imageUrl: src,

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }
    </script>
@endsection
