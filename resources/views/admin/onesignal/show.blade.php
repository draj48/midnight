@extends('layouts.admin')
@section('content')

    <div class="max-w-4xl mx-auto w-full" x-data="post()">
        <form method="POST">
            @csrf

            <div class="py-8 flex gap-x-10">
                <div class="flex justify-center lg:w-full lg:max-w-xs mb-5" x-data="{imageUrl:''}">
                    <label for="image-file"
                           class="flex flex-col items-center justify-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG or JPG
                                (Size. {{config('attr.poster.broadcast_size_x').'x'.config('attr.poster.broadcast_size_y')}}
                                )</p>
                        </div>
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            >
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="image" id="image-file" type="file" class="hidden" accept="image/*" x-ref="image"
                               @change="imageViewer().fileChosen">
                    </label>
                </div>
                <div class="flex-1">

                    <div class="mb-5">
                        <x-form.label for="link" :value="__('Link')"/>
                        <x-form.input id="link" name="link" type="text" class="mt-1 block w-full"
                                      value="{{ old('link') }}"
                                      placeholder="{{__('https://')}}"/>

                    </div>
                    <div class="mb-5">
                        <x-form.label for="onesignal_key" :value="__('Message')"/>
                        <x-form.textarea name="message" placeholder="{{__('Message')}}">{{ old('message') }}</x-form.textarea>
                    </div>
                    <x-form.primary class="w-full max-w-xs">{{__('Submit')}}</x-form.primary>
                </div>
            </div>
        </form>
    </div>

    @push('javascript')

        <script>

            function post() {
                return {
                    imageUrl: null,
                    imageViewer(src = '') {
                        return {
                            fileChosen(event) {
                                this.imageViewer().fileToDataUrl(event, src => this.imageUrl = src)
                            },
                            fileToDataUrl(event, callback) {
                                if (!event.target.files.length) return

                                let file = event.target.files[0],
                                    reader = new FileReader()

                                reader.onload = e => callback(e.target.result)
                                reader.readAsDataURL(file)
                            }
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
