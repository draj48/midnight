@php
    $ads = \App\Models\Advertisement::where('id', $id)->where('status','publish')->first();
@endphp
@if(isset($ads->body))
    <div class="text-center mb-4">{!!html_entity_decode($ads->body)!!}</div>
@endif
