@extends('layouts.app')
@section('content')

    <livewire:post-filter :param="$param" :type="$param['type']" :genre="$param['genre']" />

    @push('javascript')

        <script>
            // waiting for DOM loaded
            document.addEventListener('DOMContentLoaded', function () {

                // listen for the event
                Livewire.on('scrollTop', param => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
                Livewire.on('urlChanged', param => {
                    history.pushState(null, null, `${document.location.pathname}?${param.url}`);
                });
            });
        </script>
    @endpush
@endsection
