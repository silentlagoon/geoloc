<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateGeolocation;
use App\Services\ExcelService;
use App\Services\FileService;

class ParserController extends Controller
{
    public function index()
    {
        return view('parser.index');
    }

    public function generateGeolocation(GenerateGeolocation $request, FileService $fileService, ExcelService $excelService)
    {
        $filePath = $fileService->saveGeolocationFile($request);
        $excelService->generateGeolocation($request, $filePath, $excelService->getColumnCellIndex($request->input('address_col')));
        return $fileService->downloadGeolocationFile($request);
    }
}