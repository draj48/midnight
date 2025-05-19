<div>
    @if($model->comment != 'active' AND config('settings.comment') != 'active')
        <div class="flex items-center text-sm gap-x-2 mb-4">
            <div class="relative flex gap-x-3">
                <button
                    class="text-gray-400 hover:text-gray-200 hover:underline cursor-pointer {{ $orderable === 'id' ? '!text-gray-100' : '' }}"
                    wire:click="orderablex('id')">{{__('Newest')}}</button>
                <button
                    class="text-gray-400 hover:text-gray-200 hover:underline cursor-pointer {{ $orderable === 'likes_count' ? '!text-gray-100' : '' }}"
                    wire:click="orderablex('likes_count')">{{__('Most liked')}}</button>
            </div>
            <div
                class="py-2 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:mx-5 dark:text-gray-500 dark:before:border-gray-900 dark:after:border-gray-600 flex-1"></div>
            <div class="text-gray-500">{{__(':total comments',['total' => $comments->count()])}}</div>
        </div>
        @auth
            @include('livewire.partials.comment-form',[
                'method'=>'postComment',
                'state'=>'newCommentState',
                'inputId'=> 'comment',
                'inputLabel'=> 'Your comment',
                'button'=>'Submit comment'
            ])
        @else
            <x-form.secondary href="{{route('login')}}"
                              class="!rounded-full !px-6 !py-2.5 mb-6 !text-sm">{{__('Log in to comment !')}}</x-form.secondary>
        @endauth
        @if($comments->count())
            @foreach($comments as $comment)
                <livewire:comment :comment="$comment" :key="$comment->id"/>
            @endforeach
            {{$comments->links()}}
        @else
            <p class="text-gray-500">{{__('No comments yet!')}}</p>





 


















        @endif
    @endif
</div>
