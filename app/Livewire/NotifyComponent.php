<?php

namespace App\Livewire;

use Livewire\Component;

class NotifyComponent extends Component
{

    public $message;

    protected $listeners = ['show-toast' => 'showToast'];

    public $showToastr = false;
    public function showToast($message)
    {
        $this->showToastr = true;
        $this->message = $message;
    }
    public function render()
    {
        return view('livewire.notify-component');
    }
}
