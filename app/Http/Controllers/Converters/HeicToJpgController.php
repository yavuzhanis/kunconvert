<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Imagick;

class HeicToJpgController extends Controller
{
    public function index()
    {
        return view('converters.heic-to-jpg');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:heic,heif'
        ]);

        $filePath = $request->file('image')->getRealPath();

        // Imagick ile HEIC dosyasını oku
        $image = new Imagick($filePath);
        $image->setImageFormat('jpeg');
        $image->setImageCompressionQuality(90);

        $jpgBlob = $image->getImageBlob();
        $fileName = 'converted_' . time() . '.jpg';

        return response($jpgBlob)
            ->header('Content-Type', 'image/jpeg')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
