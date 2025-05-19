<?php

namespace App\Http\Controllers;
use App\Http\Middleware\RedirectToInstaller;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use App\Install\Requirement;
use App\Install\Database;
use App\Install\AppSettings;
use Exception;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectToInstaller::class);
    }

    public function index(Requirement $requirement)
    {
        return view('install.index', compact('requirement'));
    }

    public function config(Requirement $requirement)
    {
        if (! $requirement->satisfied()) {
            return redirect()->route('install.index');
        }
        return view('install.config', compact('requirement'));
    }

    public function store(Request $request,Database $database,AppSettings $settings) {

        try {
            $database->setup($request);
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        return redirect('install/complete');
    }

    public function complete(Factory $cache)
    {
        $env = DotenvEditor::load();
        $env->autoBackup(false);
        $env->setKey('APP_ENV', 'production');
        $env->setKey('APP_DEBUG', 'false');
        $env->save();
        if (env('APP_ENV') == 'production') {
            return redirect()->route('index');
        }


        return view('install.complete');
    }
}
