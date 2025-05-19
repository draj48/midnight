<?php

namespace App\Livewire;

use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReactionComponent extends Component
{
    public $model;
    public $reaction;
    public $isReaction = null;

    public function mount($model,$isReaction = null)
    {
        $this->model = $model;
        $this->isReaction = $isReaction;
    }

    public function render()
    {
        $user = Auth::user();
        if($user) {
            $listing = $this->model->getReaction($user)->first();
            $this->isReaction = $listing->reaction ?? null;
        }
        return view('livewire.reaction-component');
    }

    public function reactionButton($reaction)
    {
        $user = Auth::user();
        if ($user) {
            $listing = $this->model->getReaction($user)->first();

            if (isset($listing->reaction) and $reaction == $listing->reaction) {
                $listing->delete();
            } elseif (!empty($listing)) {
                $listing->reaction = $reaction;
                $listing->save();
            } else {
                $data = new Reaction();
                $data->reaction = $reaction;
                $data->user_id = $user->id;
                $this->model->reactions()->save($data);
            }

            return response()->json([
                'bool' => true,
                'like' => $this->model->likes()->count(),
                'dislike' => $this->model->dislikes()->count(),
            ]);
        } else {
            $this->redirect(route('login'));
        }
    }
}
