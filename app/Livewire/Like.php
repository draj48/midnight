<?php

namespace App\Livewire;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Like extends Component
{

    public $comment;
    public $count;


    public function mount(\App\Models\Comment $comment): void
    {
        $this->comment = $comment;
        $this->count = $comment->likes()->count();
    }

    public function like(): void
    {
        if ($this->comment->isLiked()) {
            $this->comment->removeLike();

            $this->count--;
        } elseif (auth()->user()) {
            $this->comment->likes()->create([
                'user_id' => auth()->id(),
            ]);

            $this->count++;
        }
    }

    /**
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application|null
     */
    public function render(
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|null
    {
        return view('livewire.like');
    }

}
