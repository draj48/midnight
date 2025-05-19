<?php

namespace App\Install;

use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class AppSettings
{
    public function setup($data)
    {
        $this->generateAppKey();
    }

    private function generateAppKey()
    {
        Artisan::call('key:generate', ['--force' => true]);
    }


}
