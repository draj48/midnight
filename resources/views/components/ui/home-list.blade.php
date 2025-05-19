<div class="pb-6 lg:pb-14">
    <div
        class="flex flex-col lg:flex-row lg:items-center mb-6">
        <h3 class="text-lg xl:text-xl dark:text-white font-semibold lg:text-left rtl:!text-right capitalize flex-1">{{$module->title}}</h3>
    </div>
    @if(isset($module->arguments->listing) AND $module->arguments->listing == 'slide')
        <div class="swiper-{{$layout}} swiper-index relative">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($listings as $listing)
                        <div class="swiper-slide">
                            @if(isset($card) AND $card == 'post')
                                <x-ui.post :listing="$listing"/>
                            @elseif(isset($card) AND $card == 'broadcast')
                                <x-ui.broadcast :listing="$listing"/>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="swiper-button-prev">
            </div>
            <div class="swiper-button-next">
            </div>
        </div>
    @else
        <div class="grid grid-cols-2 xl:grid-cols-6 2xl:grid-cols-8 gap-6">
            @foreach($listings as $listing)
                @if(isset($card) AND $card == 'post')
                    <x-ui.post :listing="$listing"/>
                @elseif(isset($card) AND $card == 'broadcast')
                    <x-ui.broadcast :listing="$listing"/>
                @endif
            @endforeach
        </div>
    @endif
</div>

@push('javascript')

    <script>
        var {{$layout}} = new Swiper(".swiper-{{$layout}} .swiper", {
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-{{$layout}} .swiper-button-next",
                prevEl: ".swiper-{{$layout}} .swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1300: {
                    slidesPerView: 6,
                },
                1500: {
                    slidesPerView: 8,
                },
                2000: {
                    slidesPerView: 8,
                },
            },
        });
    </script>
@endpush
