<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HtmlTableToExcelController extends Controller
{
    public function index()
    {
        return view('converters.html-table-to-excel');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'htmlcode' => 'required|string',
        ]);

        $html = $request->htmlcode;

        // HTML içindeki tabloyu çek
        preg_match('/<table.*?>.*?<\/table>/si', $html, $matches);

        if (!isset($matches[0])) {
            return back()->withErrors(['HTML içinde bir <table> bulunamadı.']);
        }

        $table = $matches[0];

        // DOM ile parse edelim
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($table);
        libxml_clear_errors();

        $rows = $dom->getElementsByTagName("tr");

        // Excel oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowNumber = 1;

        foreach ($rows as $tr) {
            $cells = $tr->getElementsByTagName("td");
            if ($cells->length == 0) {
                $cells = $tr->getElementsByTagName("th"); // başlıklar için
            }

            $colLetter = 'A';
            foreach ($cells as $cell) {
                $sheet->setCellValue($colLetter . $rowNumber, trim($cell->textContent));
                $colLetter++;
            }

            $rowNumber++;
        }

        $fileName = 'html_table_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        ]);
    }
}
