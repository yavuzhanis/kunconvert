<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JsonToExcelController extends Controller
{
    public function index()
    {
        return view('converters.json-to-excel');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'jsonfile' => 'required|file|mimes:json,txt'
        ]);

        $filePath = $request->file('jsonfile')->getRealPath();
        $jsonData = json_decode(file_get_contents($filePath), true);

        if (!$jsonData) {
            return back()->withErrors(['JSON formatı okunamadı.']);
        }

        // JSON array değilse kullanıcıyı uyaralım
        if (!is_array($jsonData)) {
            return back()->withErrors(['JSON bir dizi (array) formatında olmalıdır.']);
        }

        // Excel oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Başlıkları otomatik al
        $headers = array_keys($jsonData[0]);
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        // Verileri yaz
        $row = 2;
        foreach ($jsonData as $item) {
            $col = 'A';
            foreach ($headers as $h) {
                $sheet->setCellValue($col . $row, $item[$h] ?? '');
                $col++;
            }
            $row++;
        }

        // Kaydet ve indir
        $outputName = 'converted_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $outputName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
