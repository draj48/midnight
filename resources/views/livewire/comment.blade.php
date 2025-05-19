<div>
    @if($isEditing)
        @include('livewire.partials.comment-form',[
            'method'=>'editComment',
            'state'=>'editState',
            'inputId'=> 'reply-comment',
            'inputLabel'=> 'Your Reply',
            'button'=>'Edit Comment'
        ])
    @else
        <article class="mb-6 text-base">
            <div class="flex gap-x-6">
                {!! gravatar($comment->user->name,$comment->user->avatarurl,'h-9 w-9 rounded-full bg-primary-500 text-xs font-bold flex items-center justify-center text-white') !!}
                <div class="flex-1">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-500 gap-x-2">
                        <a href="" class="hover:underline text-white">{{$comment->user->username}}</a>
                        @if($comment->user->account_type == 'admin')
                            <span class="text-amber-400 cursor-pointer tooltip"
                                  data-tippy-content="{{__('Moderator')}}">
                        <x-ui.icon name="mod" class="w-5 h-5" fill="currentColor"/>
                        </span>
                        @endif
                        <time class="text-xs " pubdate datetime="{{$comment->presenter()->relativeCreatedAt()}}"
                              title="{{$comment->presenter()->relativeCreatedAt()}}">
                            {{$comment->presenter()->relativeCreatedAt()}}
                        </time>
                    </div>
                    <div class="text-gray-500 text-sm mt-1 dark:text-gray-400">
                        {!! $comment->presenter()->replaceUserMentions($comment->presenter()->markdownBody()) !!}
                    </div>
                    <div class="flex items-center mt-1 -mx-2 gap-x-4 text-xs text-gray-500 dark:text-gray-400">
                        <livewire:like :comment="$comment" :key="$comment->id"/>
                        @auth
                            @if($comment->isParent())
                                <button type="button" wire:click="$toggle('isReplying')"
                                        class="flex items-center hover:underline">
                                    {{__('Reply')}}
                                </button>
                            @endif
                        @endauth

                        @can('update',$comment)
                            <button wire:click="$toggle('isEditing')" type="button"
                                    class="block hover:underline">{{__('Edit')}}
                            </button>
                        @endcan
                        @can('destroy',$comment)

                            <button
                                x-on:click="confirmCommentDeletion"
                                x-data="{
                                    confirmCommentDeletion(){
                                        if(window.confirm('You sure to delete this comment?')){
                                            @this.call('deleteComment')
                                        }
                                    }
                                }"
                                class="block hover:underline text-red-400">
                                {{__('Delete')}}
                            </button>

                        @endcan
                    </div>

                    @if($isReplying)
                        <div class="mt-3">
                            @include('livewire.partials.comment-form',[
                               'method'=>'postReply',
                               'state'=>'replyState',
                               'inputId'=> 'reply-comment',
                               'inputLabel'=> 'Your Reply',
                               'button'=>'Post Reply'
                           ])
                        </div>
                    @endif
                    @if($comment->children->count())
                        <button type="button" wire:click="$toggle('hasReplies')"
                                class="flex items-center gap-x-3 text-sm text-gray-400 mt-2 hover:underline">
                            @if(!$hasReplies)
                                {{__('Show :total replies',['total' => $comment->children->count()])}}
                            @else
                                {{__('Hide Replies')}}

                            @endif
                        </button>
                    @endif
                </div>
            </div>

        </article>
    @endif

    @if($hasReplies)
        <article class="lg:ml-14">
            @foreach($comment->children as $child)
                <livewire:comment :comment="$child" :key="$child->id"/>
            @endforeach
        </article>
    @endif

</div>

