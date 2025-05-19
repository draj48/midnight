<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use OneSignal;

class PostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $sendNotification;

    public function __construct(Post $post, $sendNotification)
    {
        $this->post = $post;
        $this->sendNotification = $sendNotification;
    }

    public function handle()
    {
        if ($this->sendNotification == 'active') {

            $content = str_replace('[title]',$this->post->title,config('settings.onesignal_message'));
            $notification = [
                'contents' => [
                    'en' => $content
                ],
                'url' => route($this->post->type,$this->post->slug),
                'big_picture' => $this->post->coverurl,
                'chrome_web_image' => $this->post->coverurl,
                'huawei_big_picture' => $this->post->coverurl,
                'included_segments' => ['All']
            ];

            OneSignal::sendNotificationCustom($notification);
        }
    }
}
