<?php

namespace App\Livewire;

use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Artisan;
use Illuminate\Support\Facades\Storage;

class UpdateComponent extends Component
{
    public $data;
    public $message = '';

    public function mount()
    {

        $response = Http::post('https://codelug.com/update/check', [
            'license_key' => env('LICENSE_KEY')
        ]);
        $this->data = json_decode($response->body(),true);
    }


    public function updateClick()
    {

        $data = $this->data;
        $currentVersion = $data['current'];

        $targetVersion = env('APP_VERSION');
        $versionId = null;
        $versionName = null;

        foreach ($data['versions'] as $version) {
            if (version_compare($version['version'], $targetVersion, '>') && version_compare($version['version'], $currentVersion, '<=')) {
                $versionId      = $version['id'];
                $versionName    = $version['version'];
                break;
            }
        }
        $response = Http::post('https://codelug.com/update/install', [
            'license_key' => env('LICENSE_KEY'),
            'version' => $versionId,
        ]);
        $result = json_decode($response->body(),true);

        if($response->status() AND isset($versionName)) {
            $update_folder =config('attr.update');

            if (!file_exists(public_path($update_folder))) {
                mkdir(public_path($update_folder), 0777, true);
            }
            $filePath = public_path(config('attr.update') . $versionName.'.zip'); // Dosyanın konumu
            $client = new \GuzzleHttp\Client();
            $client->request('GET', $result['file'], ['sink' => $filePath, 'verify' => false, 'timeout' => 10]);
            if(isset($filePath)) {
            $extractPath = base_path();
            $zipFilePath = $filePath;
            $zip = new ZipArchive;
            if ($zip->open($zipFilePath) === true) {
                Artisan::call('down');
                if (!File::isDirectory($extractPath)) {
                    File::makeDirectory($extractPath, 0755, true);
                }
                $zip->extractTo($extractPath);
                $zip->close();

                if(isset($versionName) AND env('APP_VERSION') != $versionName) {
                    $file = DotenvEditor::autoBackup(false);
                    $file = DotenvEditor::setKey('APP_VERSION', $versionName);
                    $file->save();
                }
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('up'); // Maintenance mode ON
                $this->message = 'Update completed';
            } else {
                $this->message = 'Update failed';
            }
            }
        }
    }
    public function render()
    {
        return view('livewire.update-component');
    }
}
