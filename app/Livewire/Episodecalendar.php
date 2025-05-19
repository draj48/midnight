<?php

namespace App\Livewire;

use App\Models\PostEpisode;
use Livewire\Component;

class Episodecalendar extends Component
{
    public $day;
    public function render()
    {

        $startDate = now()->subDays(15);
        $dates = [];

        for ($i = 0; $i < 15; $i++) {
            $date = $startDate->addDay();
            $dates[$i]['date'] = $date->format('Y-m-d');
            $dates[$i]['format'] = $date->translatedFormat('d M');
            $dates[$i]['text'] = $date->format('Y-m-d') == now()->format('Y-m-d') ? __('Today') : $date->translatedFormat('D');
            $dates[$i]['selected'] = $date->format('Y-m-d') == now()->format('Y-m-d') ? 'active' : 'disable';
        }
        $dates = array_reverse($dates);

        if($this->day) {
            $listings = PostEpisode::where('status','publish')->whereDate('created_at',$this->day)->limit($limit ?? 24)->orderby('id', 'desc')->get();
        } else {
            $listings = PostEpisode::where('status','publish')->whereDate('created_at',now()->format('Y-m-d'))->limit($limit ?? 24)->orderby('id', 'desc')->get();
        }
        return view('livewire.episodecalendar',compact('dates','listings'));
    }
}
