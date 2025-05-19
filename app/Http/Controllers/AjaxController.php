<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AjaxController extends Controller
{


    public function switchLang($lang)
    {
        session()->put('locale', $lang);

        return redirect()->back();
    }
}
