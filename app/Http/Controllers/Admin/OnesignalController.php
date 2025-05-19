<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use OneSignal;

class OnesignalController extends Controller
{
    public function show(Request $request)
    {
        $config = [
            'title' => __('Tool'),
            'nav' => 'tool',
        ];
        if (!config('settings.onesignal_id') || !config('settings.onesignal_id')) {
            return redirect()->route('admin.onesignal.settings');
        }
        return view('admin.onesignal.show', compact('config', 'request'));
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'message' => 'required|string|max:255'
        ]);

        $uploaded_image = null;
        if ($request->hasFile('image')) {
            $imagename = Str::random(10);
            $imageFile = $request->image;
            $uploaded_image = fileUpload($imageFile, config('attr.onesignal.path'), config('attr.onesignal.size_x'), config('attr.onesignal.size_y'), $imagename);
        }

        $notification = [
            'contents' => [
                'en' => $request->message
            ],
            'url' => $request->link,
            'big_picture' => $uploaded_image,
            'chrome_web_image' => $uploaded_image,
            'huawei_big_picture' => $uploaded_image,
            'included_segments' => ['All']
        ];

        OneSignal::sendNotificationCustom($notification);

        return redirect()->route('admin.onesignal.show')->with('success', __(':title submit', ['title' => 'Notification']));
    }

    public function settings(Request $request)
    {
        $config = [
            'title' => __('Tool'),
            'nav' => 'tool',
        ];
        return view('admin.onesignal.settings', compact('config', 'request'));
    }

    public function update(Request $request)
    {
        $save_data = [
            'onesignal_message'
        ];
        foreach ($save_data as $item) {
            update_settings($item, $request->$item);
        }
        Cache::forget('settings');
        Cache::flush();

        return redirect()->route('admin.onesignal.settings')->with('success', __(':title has been updated', ['title' => 'Tool']));
    }
}
