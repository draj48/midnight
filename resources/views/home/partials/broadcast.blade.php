@if(count($listings['broadcast']) > 0)
<x-ui.home-list :listings="$listings['broadcast']" :module="$module" layout="broadcast" card="broadcast" :heading="__('Live broadcast')" />
@endif
