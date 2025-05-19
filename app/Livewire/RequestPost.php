<?php

namespace App\Livewire;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Validate;

class RequestPost extends Component
{
    use WithRateLimiting;
    public $listing;

    public function mount($listing) {
        $this->listing = $listing;
    }
    public function render()
    {
        return view('livewire.request-post');
    }
    public function requestForm() {


        try {
            $this->rateLimit(3,300);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => $this->dispatch('show-toast', [ 'message' => __("Slow down! Please wait another {$exception->secondsUntilAvailable} seconds")])->to(NotifyComponent::class),
            ]);
        }

        $model = \App\Models\RequestPost::firstOrNew([
            'type' =>  $this->listing['type'],
            'tmdb_id' => $this->listing['id'],
            'title' => $this->listing['title'],
            'image' => $this->listing['image']
        ]);

        $model->request = (int) $model->request + 1;

        $model->save();
        $this->dispatch('show-toast', [ 'message' => __('Submit request')])->to(NotifyComponent::class);

    }
}
