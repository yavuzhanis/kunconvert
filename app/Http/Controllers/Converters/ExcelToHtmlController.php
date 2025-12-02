<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelToHtmlController extends Controller
{
    public function index()
    {
        return view('converters.excel-to-html');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'excelfile' => 'required|mimes:xls,xlsx'
        ]);

        $filePath = $request->file('excelfile')->getRealPath();

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $html = '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        return view('converters.excel-to-html-result', compact('html'));
    }
}
