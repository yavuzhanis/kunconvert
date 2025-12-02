<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PngToJpgController extends Controller
{
    public function index()
    {
        return view('converters.png-to-jpg');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:png'
        ]);

        $png = imagecreatefrompng($request->file('image')->getRealPath());
        imagepalettetotruecolor($png); // transparan sorunlarını giderir
        imagealphablending($png, true);
        imagesavealpha($png, true);

        $jpgFile = 'png_to_jpg_' . time() . '.jpg';
        $fullPath = storage_path('app/' . $jpgFile);

        // PNG → JPG
        imagejpeg($png, $fullPath, 90);

        return response()->download($fullPath)->deleteFileAfterSend(true);
    }
}
