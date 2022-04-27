<?php

namespace Zhivkov\SedImplementation\Repositories;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SedRepository
{

    public function substitution(\Illuminate\Http\Request $request)
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
