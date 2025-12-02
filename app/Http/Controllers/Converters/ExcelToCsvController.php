<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelToCsvController extends Controller
{
    public function index()
    {
        return view('converters.excel-to-csv');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'excelfile' => 'required|file|mimes:xlsx,xls'
        ]);

        // Dosyayı oku
        $file = $request->file('excelfile')->getRealPath();

        // Excel dosyasını yükle
        $spreadsheet = IOFactory::load($file);

        // CSV writer
        $writer = IOFactory::createWriter($spreadsheet, 'Csv');
        $writer->setDelimiter(",");
        $writer->setEnclosure('"');
        $writer->setLineEnding("\n");

        // Dosya adı
        $outputName = 'converted_' . time() . '.csv';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $outputName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
