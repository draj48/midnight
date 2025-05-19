@if(count($listings['tv']) > 0)
<x-ui.home-list :listings="$listings['tv']" :module="$module" layout="tv" :heading="__('Latest TV Shows')" card="post" />
@endif
