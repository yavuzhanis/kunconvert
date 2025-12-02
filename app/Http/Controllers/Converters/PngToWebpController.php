<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Imagick;

class PngToWebpController extends Controller
{
    public function index()
    {
        return view('converters.png-to-webp');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:png'
        ]);

        $input = $request->file('image')->getRealPath();

        $image = new Imagick($input);
        $image->setImageFormat('webp');
        $image->setOption('webp:lossless', 'true'); // PNG → WEBP dönüşümünde kaliteyi korur

        $webpBlob = $image->getImageBlob();
        $fileName = "converted_" . time() . ".webp";

        return response($webpBlob)
            ->header('Content-Type', 'image/webp')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
