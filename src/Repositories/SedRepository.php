<?php

namespace Zhivkov\SedImplementation\Repositories;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SedRepository
{

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function substitution(\Illuminate\Http\Request $request) :StreamedResponse
    {
        $this->validateRequest($request, 'search');
        $this->validateRequest($request, 'replace');

        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        $folderPath = public_path('sed_files');

        $this->prepareFolder($folderPath);

        $uploadedFile->move($folderPath, $filename);

        $filepath = $folderPath.'\\'.$filename;
        $filepath = Str::replace('\\', '\\\\', $filepath);

        $this->validateFile($filepath);

        try {
            Artisan::call('sed:substitution', [
                '--search' => $request->search,
                '--replace' => $request->replace,
                '--file' => $filepath
            ]);
        } //catch exception
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        Config::set('filesystems.disks.sed', [
            'driver' => 'local',
            'root' => public_path('/sed_files'),
            'url' => env('APP_URL') . '/sed_files',
            'visibility' => 'public',
        ]);

        return Storage::disk('sed')->download($filename);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @throws \Exception
     */
    protected function validateRequest(\Illuminate\Http\Request $request, $field): void
    {
        if (!$request->has($field) || empty($request->get($field))) {
            throw new \Exception($field.' field is required');
        }
    }

    /**
     * @param  string  $filepath
     */
    protected function validateFile(string $filepath): void
    {
        if (!file_exists($filepath)) {
            die($filepath.' not exists');
        }

        if (!is_writable($filepath)) {
            die($filepath.' id not writable');
        }
    }

    /**
     * @param  string  $folderPath
     */
    protected function prepareFolder(string $folderPath): void
    {
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
    }

}
