<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PostTrait;

class ToolController extends Controller
{
    use PostTrait;

    public function index(Request $request)
    {
        $config = [
            'title' => __('Tools'),
            'nav' => 'tool',
        ];

        return view('admin.tool.index', compact('config'));
    }



}
