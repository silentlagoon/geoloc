<?php

namespace App\Services;

use App\Http\Requests\GenerateGeolocation;

class ExcelService
{
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    /**
     * @param GenerateGeolocation $request
     * @param string $filePath
     * @param int $addressCellColumnIndex
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generateGeolocation(GenerateGeolocation $request, string $filePath, int $addressCellColumnIndex) : void
    {
        $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $worksheet  = $reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $writer     = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($reader);

        $writer->setPreCalculateFormulas(false);
        for ($row = $request->input('row_start_index'); $row <= $highestRow; ++$row) {
            $address = $worksheet->getCellByColumnAndRow($addressCellColumnIndex, $row)->getValue();

            if( ! $address) {
                continue;
            }

            $geolocation = $this->geolocationService->getGeolocation($address, $request->input('api_key', null));
            $worksheet->setCellValue($request->input('lat_output_col') . $row, $geolocation['lat']);
            $worksheet->setCellValue($request->input('long_output_col') . $row, $geolocation['long']);
        }

        $writer->save($filePath);
    }

    /**
     * @param $addressColumn
     * @return false|int|string
     */
    public function getColumnCellIndex($addressColumn)
    {
        $alphabet       = range('A', 'Z');
        $alphabetLength = count($alphabet);
        $rotateAlphabet = 0;
        $colIndex       = 0;

        for($i = 0; $i < mb_strlen($addressColumn); $i++) {
            $actualLetter = mb_substr($addressColumn, $i, 1, 'utf-8');
            $colIndex = array_search($actualLetter, $alphabet) + 1 + $rotateAlphabet;
            $rotateAlphabet += $alphabetLength;
        }

        return $colIndex;
    }
}