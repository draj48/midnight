<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class UpdaterController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Updater'),
            'nav' => 'settings',
        ];
        return view('admin.updater.index',compact('config'));
    }
}
