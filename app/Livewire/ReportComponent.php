<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Validation\ValidationException;

class ReportComponent extends Component
{
    use WithRateLimiting;
    public $model;
    public $type;
    public $description;
    public $reportModal = false;

    public function mount($model) {
        $this->model = $model;
    }
    public function render()
    {
        return view('livewire.report');
    }
    public function reportForm() {


        try {
            $this->rateLimit(1,300);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => "Slow down! Please wait another {$exception->secondsUntilAvailable} seconds",
            ]);
        }

        $this->validate([
            'type' => 'required|min:1|max:2',
            'description' => 'required|min:5|max:500'
        ]);
        $this->model->report()->create([
            'type' => $this->type,
            'description' => $this->description,
        ]);
        $this->reset(['type', 'description']);
        $this->reportModal = false;
        $this->dispatch('show-toast', [ 'message' => __('Submit report')])->to(NotifyComponent::class);

    }
}
