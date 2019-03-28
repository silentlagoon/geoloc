<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateGeolocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParserController extends Controller
{
    public function testIndex()
    {
        return view('parser.index');
    }

    public function generateGeolocation(GenerateGeolocation $request)
    {
        $alphabet = range('A', 'Z');
        $addressCellColumnIndex = array_search($request->input('address_col'), $alphabet) + 1;

        $filename = 'ub_addresses.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load(base_path($filename));

        $worksheet = $reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($reader);
        $writer->setPreCalculateFormulas(false);
        for ($row = $request->input('row_start_index'); $row <= $highestRow; ++$row) {
            $address = $worksheet->getCellByColumnAndRow($addressCellColumnIndex, $row)->getValue();

            if( ! $address) {
                continue;
            }

            try {
                $geolocation = $this->getGeolocation($address);
                $worksheet->setCellValue($request->input('lat_output_col') . $row, $geolocation['lat']);
                $worksheet->setCellValue($request->input('long_output_col') . $row, $geolocation['long']);
                $writer->save(base_path($filename));
            }
            catch(\Exception $e) {
                continue;
            }
        }
    }
    public function index()
    {
        $addressCell = 'E';
        $lattitudeOutputCell = 'I';
        $longitudeOutputCell = 'J';

        $alphabet = range('A', 'Z');
        $addressCellColumnIndex = array_search($addressCell, $alphabet) + 1;

        $filename = 'ub_addresses.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load(base_path($filename));

        $worksheet = $reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($reader);
        $writer->setPreCalculateFormulas(false);
        for ($row = 2; $row <= $highestRow; ++$row) {
            $address = $worksheet->getCellByColumnAndRow($addressCellColumnIndex, $row)->getValue();

            if( ! $address) {
                continue;
            }

            try {
                $geolocation = $this->getGeolocation($address);
                $worksheet->setCellValue($lattitudeOutputCell . $row, $geolocation['lat']);
                $worksheet->setCellValue($longitudeOutputCell . $row, $geolocation['long']);
                $writer->save(base_path($filename));
            }
            catch(\Exception $e) {
                continue;
            }
        }
    }

    private function getGeolocation($address)
    {
        $MY_API_KEY = 'AIzaSyBldjHDJrh_or4xDnM22MAbOACBySMYUi4';

        $address    = urlencode($address);
        $geocode    = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$MY_API_KEY}");
        $output     = json_decode($geocode);

        return [
            'lat'   => $output->results[0]->geometry->location->lat,
            'long'  => $output->results[0]->geometry->location->lng
        ];
    }

    private function saveFile(GenerateGeolocation $request)
    {
        Storage::putFileAs('photos', $request->file('file'), $request->input('output_filename'));
    }
}