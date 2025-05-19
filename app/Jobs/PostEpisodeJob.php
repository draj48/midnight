<?php

namespace App\Jobs;

use App\Models\PostEpisode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OneSignal;

class PostEpisodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postEpisode;
    protected $sendNotification;
    public function __construct(PostEpisode $postEpisode,$sendNotification)
    {
        $this->postEpisode = $postEpisode;
        $this->sendNotification = $sendNotification;
    }

    public function handle()
    {
        if ($this->sendNotification == 'active') {
            $content = str_replace('[title]',$this->postEpisode->post->title.' '.$this->postEpisode->season->season_number.'x'.$this->postEpisode->episode_number,config('settings.onesignal_message'));
            $notification = [
                'contents' => [
                    'en' => $content
                ],
                'url' => route('episode',['slug'=>$this->postEpisode->post->slug,'season'=>$this->postEpisode->season->season_number,'episode'=>$this->postEpisode->episode_number]),
                'big_picture' => $this->postEpisode->imageurl,
                'chrome_web_image' => $this->postEpisode->imageurl,
                'huawei_big_picture' => $this->postEpisode->imageurl,
                'included_segments' => ['All']
            ];

            OneSignal::sendNotificationCustom($notification);
        }
    }
}
