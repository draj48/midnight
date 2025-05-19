<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public $model;
    public $orderable = 'id';
    public $users = [];

    public $showDropdown = false;

    public $newCommentState = [
        'body' => ''
    ];


    protected $listeners = [
        'refresh' => '$refresh'
    ];

    protected $validationAttributes = [
        'newCommentState.body' => 'comment'
    ];

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with('user', 'children.user', 'children.children')
            ->parent()
            ->where('status', 'publish')
            ->orderBy($this->orderable,'desc')
            ->paginate(10);

        return view('livewire.comments', [
            'comments' => $comments
        ]);
    }

    #[On('refresh')]
    public function postComment(): void
    {
        $this->validate([
            'newCommentState.body' => 'required|min:5|max:500'
        ]);


        $comment = $this->model->comments()->make($this->newCommentState);
        $comment->user()->associate(auth()->user());
        $comment->status = config('settings.comment_status') == 'active' ? 'draft' : 'publish';
        $comment->save();

        $this->newCommentState = [
            'body' => ''
        ];
        $this->users = [];
        $this->showDropdown = false;

        $this->dispatch('show-toast', [ 'message' => __('Posted comment')])->to(NotifyComponent::class);
        $this->resetPage();
        session()->flash('message', 'Comment Posted Successfully!');
    }

    #[On('refresh')]
    public function sortId()
    {
        $this->orderable = 'id';
    }

    #[On('refresh')]
    public function orderablex($type = null)
    {
        if($type == 'likes_count') {
            $this->orderable = 'likes_count';
        } else {
            $this->orderable = 'id';
        }
    }
}
