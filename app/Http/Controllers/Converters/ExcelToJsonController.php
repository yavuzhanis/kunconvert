<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelToJsonController extends Controller
{
    public function index()
    {
        return view('converters.excel-to-json');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'excelfile' => 'required|file|mimes:xls,xlsx'
        ]);

        $file = $request->file('excelfile')->getRealPath();

        // Excel dosyasını yükle
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // İlk satır başlıklar olacak
        $headers = array_values($rows[1]);
        unset($rows[1]);

        $jsonData = [];

        foreach ($rows as $r) {
            $jsonData[] = array_combine($headers, array_values($r));
        }

        // JSON çıktısı
        $outputName = 'converted_' . time() . '.json';
        $jsonOutput = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // İndirme
        return response($jsonOutput)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $outputName . '"');
    }
}
