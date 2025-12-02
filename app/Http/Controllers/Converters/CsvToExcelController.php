<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CsvToExcelController extends Controller
{
    public function index()
    {
        return view('converters.csv-to-excel');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'csvfile' => 'required|mimes:csv,txt'
        ]);

        $filePath = $request->file('csvfile')->getRealPath();

        // CSV dosyasını oku
        $rows = array_map('str_getcsv', file($filePath));

        // Excel dosyası oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowNum = 1;
        foreach ($rows as $line) {
            $col = 'A';
            foreach ($line as $value) {
                $sheet->setCellValue($col . $rowNum, $value);
                $col++;
            }
            $rowNum++;
        }

        $outputName = 'converted_' . time() . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $outputName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
