<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Dompdf\Dompdf;

class WordToPdfController extends Controller
{
    public function index()
    {
        return view('converters.word-to-pdf');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'wordfile' => 'required|file|mimes:docx'
        ]);

        $filePath = $request->file('wordfile')->getRealPath();

        // Word dosyasını oku
        $phpWord = IOFactory::load($filePath);

        // PDF motorunu DomPDF olarak ayarla
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

        // Geçici PDF dosyası
        $pdfPath = storage_path('app/public/converted_' . time() . '.pdf');

        $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
        $pdfWriter->save($pdfPath);

        // Kullanıcıya PDF indirme
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
