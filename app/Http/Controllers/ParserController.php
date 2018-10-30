<?php

namespace App\Http\Controllers;

class ParserController extends Controller
{
    public function index()
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load(base_path('1.xls'));

        $worksheet = $reader->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // e.g. 10

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($reader);
        $writer->setPreCalculateFormulas(false);
        for ($row = 300; $row <= $highestRow; ++$row) {
            $address = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            try {
                $geolocation = $this->getGeolocation($address);
                $worksheet->setCellValue('Y'.$row, $geolocation['lat']);
                $worksheet->setCellValue('Z'.$row, $geolocation['long']);
                $writer->save(base_path('1.xls'));
            }
            catch(\Exception $e) {
                continue;
            }
        }
    }

    private function getGeolocation($address)
    {
        $MY_API_KEY = 'AIzaSyBldjHDJrh_or4xDnM22MAbOACBySMYUi4';
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false' . "&key=" . $MY_API_KEY);
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        return [
            'lat' => $latitude,
            'long' => $longitude
        ];
    }
}