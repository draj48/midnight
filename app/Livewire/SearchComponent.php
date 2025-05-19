<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class SearchComponent extends Component
{
    public $q = '';
    public function render()
    {
        if($this->q) {
            $posts = Post::where('title', 'like', '%' . $this->q . '%')->limit(5)->get();
        } else {
            $posts = array();
        }
        return view('livewire.search-component', [
            'posts' => $posts,
        ]);
    }
}
