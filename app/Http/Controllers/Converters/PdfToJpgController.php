<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ZipArchive;

class PdfToJpgController extends Controller
{
    public function index()
    {
        return view('converters.pdf-to-jpg');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'pdffile' => 'required|mimes:pdf'
        ]);

        $filePath = $request->file('pdffile')->getRealPath();

        // Imagick ile PDF yükle
        $imagick = new Imagick();
        $imagick->setResolution(200, 200);
        $imagick->readImage($filePath);
        $imagick->setImageFormat('jpeg');

        // Kaç sayfa var?
        $pageCount = $imagick->getNumberImages();

        // Çok sayfa varsa ZIP hazırlayalım
        if ($pageCount > 1) {

            $zipPath = storage_path('app/public/pdf2jpg_' . time() . '.zip');
            $zip = new ZipArchive();
            $zip->open($zipPath, ZipArchive::CREATE);

            foreach ($imagick as $index => $img) {
                $jpg = $img->getImageBlob();
                $name = "page_" . ($index + 1) . ".jpg";
                $zip->addFromString($name, $jpg);
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        // Tek sayfa ise direkt JPG gönder
        $jpgBlob = $imagick->getImageBlob();
        $outputName = "converted_" . time() . ".jpg";

        return response($jpgBlob)
            ->header('Content-Type', 'image/jpeg')
            ->header('Content-Disposition', 'attachment; filename="' . $outputName . '"');
    }
}
