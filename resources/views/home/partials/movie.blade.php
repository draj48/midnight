@if(count($listings['movie']) > 0)
<x-ui.home-list :listings="$listings['movie']" :module="$module" layout="movie" card="post" :heading="__('Latest Movies')" />
@endif
