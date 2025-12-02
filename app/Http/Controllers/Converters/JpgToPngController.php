<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Imagick;

class JpgToPngController extends Controller
{
    public function index()
    {
        return view('converters.jpg-to-png');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg'
        ]);

        $filePath = $request->file('image')->getRealPath();

        // Imagick ile JPG dosyasını oku
        $image = new Imagick($filePath);
        $image->setImageFormat('png');

        $pngBlob = $image->getImageBlob();
        $fileName = "converted_" . time() . ".png";

        return response($pngBlob)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
