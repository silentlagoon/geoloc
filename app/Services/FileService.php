<?php

namespace App\Services;

use App\Http\Requests\GenerateGeolocation;
use Illuminate\Support\Facades\Storage;

class FileService
{
    const EXCEL_FILE_DIRECTORY = 'excel';

    /**
     * @param GenerateGeolocation $request
     * @return string
     */
    public function saveGeolocationFile(GenerateGeolocation $request)
    {
        $url = Storage::putFileAs(self::EXCEL_FILE_DIRECTORY, $request->file('file'), $request->input('output_filename'));
        return storage_path('app' . DIRECTORY_SEPARATOR . $url);
    }

    /**
     * @param GenerateGeolocation $request
     * @param string $fileUrl
     * @return mixed
     */
    public function downloadGeolocationFile(GenerateGeolocation $request)
    {
        return Storage::download(self::EXCEL_FILE_DIRECTORY. DIRECTORY_SEPARATOR . $request->input('output_filename'));
    }
}