<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function show(Request $request,$slug)
    {

        $listing = Page::where('slug', $slug)->firstOrFail() ?? abort(404);
        // Seo
        $new = [$listing->title];
        $old = ['[title]'];

        $config['title'] = trim(str_replace($old, $new, trim(config('settings.page_title'))));
        $config['description'] = trim(str_replace($old, $new, trim(config('settings.page_description'))));

        return view('page.show', compact('config', 'listing', 'request'));
    }

    public function contact(Request $request)
    {

        // Seo
        $config['title'] = __('Contact').' - '.config('settings.title');
        $config['description'] = config('settings.description');

        return view('page.contact', compact('config', 'request'));
    }
    public function contactmail(Request $request) {

        $mailData = [
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message,
        ];
        Mail::to(config('settings.to_email'))->send(new Contact($mailData));
        return redirect()->route('contact')->with('success', __('Submitted'));
    }
}
