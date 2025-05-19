<?php

namespace App\Livewire;

use App\Models\PostSeason;
use Livewire\Component;

class SeasonComponent extends Component
{
    public $model;
    public $type;
    public $seasonId;
    public $selectEpisode;
    public $openSort;
    public $episode_number;
    public $season_number;

    public function mount($model,$seasonId = null,$type = null,$selectEpisode = null) {
        $this->model = $model;
        $this->type = $type;
        $this->selectEpisode = $selectEpisode;
        $this->seasonId = $seasonId;
    }
    public function render()
    {
        if($this->seasonId) {
            $selectSeason = PostSeason::where('post_id',$this->model->id)->where('id',$this->seasonId)->first();
            $this->season_number = $selectSeason->season_number;
        } else {
            $selectSeason = PostSeason::where('post_id',$this->model->id)->first();
            $this->season_number = $selectSeason->season_number;
        }

        return view('livewire.season-component',compact('selectSeason'));
    }
    public function updateSeason($seasonId)
    {
        $this->seasonId = $seasonId;
        $this->openSort = false;
    }
    public function goto() {
        $this->redirect(route('episode',['slug'=>$this->model->slug,'season'=>$this->season_number,'episode'=>$this->episode_number]));
    }
}
