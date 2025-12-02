<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfToWordController extends Controller
{
    public function index()
    {
        return view('converters.pdf-to-word');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'pdffile' => 'required|mimes:pdf'
        ]);

        $file = $request->file('pdffile');
        $inputPath = $file->getRealPath();

        // Geçici çıktı yolu
        $outputDir = storage_path('app/public/pdf2word_' . time());
        mkdir($outputDir);

        // LibreOffice ile PDF → DOCX dönüştürme komutu
        $command = "libreoffice --headless --convert-to docx --outdir "
                 . escapeshellarg($outputDir) . " "
                 . escapeshellarg($inputPath);

        shell_exec($command);

        // Çıktı dosyasını bul
        $pdfName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $outputPath = $outputDir . '/' . $pdfName . '.docx';

        if (!file_exists($outputPath)) {
            return back()->withErrors(['Dönüştürme sırasında bir hata oluştu.']);
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
