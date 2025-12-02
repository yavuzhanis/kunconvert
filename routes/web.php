<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Converters\ChatLogConverterController;
use App\Http\Controllers\Converters\ExcelToCsvController;
use App\Http\Controllers\Converters\ExcelToJsonController;
use App\Http\Controllers\Converters\WordToPdfController;
use App\Http\Controllers\Converters\PdfToWordController;
use App\Http\Controllers\Converters\PdfToJpgController;
use App\Http\Controllers\Converters\PngToJpgController;
use App\Http\Controllers\Converters\JpgToPngController;
use App\Http\Controllers\Converters\PngToWebpController;
use App\Http\Controllers\Converters\HeicToJpgController;
use App\Http\Controllers\Converters\CsvToExcelController;
use App\Http\Controllers\Converters\JsonToExcelController;
use App\Http\Controllers\Converters\HtmlTableToExcelController;
use App\Http\Controllers\Converters\ExcelToHtmlController;
Route::get('/', function () {
    // Ana sayfa: bütün converter’ların listeleneceği basit bir ekran
    return view('home');
})->name('home');

// Chat TXT → Excel converter
Route::get('/convert/chat-txt-to-excel', [ChatLogConverterController::class, 'index'])
    ->name('chat.txt2excel.form');

Route::post('/convert/chat-txt-to-excel', [ChatLogConverterController::class, 'convert'])
    ->name('chat.txt2excel.convert');

Route::get('/convert/excel-to-csv', [ExcelToCsvController::class, 'index'])
    ->name('excel2csv.form');

Route::post('/convert/excel-to-csv', [ExcelToCsvController::class, 'convert'])
    ->name('excel2csv.convert');

Route::get('/convert/excel-to-json', [ExcelToJsonController::class, 'index'])
    ->name('excel2json.form');

Route::post('/convert/excel-to-json', [ExcelToJsonController::class, 'convert'])
    ->name('excel2json.convert');


Route::get('/convert/word-to-pdf', [WordToPdfController::class, 'index'])
    ->name('word2pdf.form');

Route::post('/convert/word-to-pdf', [WordToPdfController::class, 'convert'])
    ->name('word2pdf.convert');

Route::get('/convert/pdf-to-word', [PdfToWordController::class, 'index'])
    ->name('pdf2word.form');

Route::post('/convert/pdf-to-word', [PdfToWordController::class, 'convert'])
    ->name('pdf2word.convert');


Route::get('/convert/pdf-to-jpg', [PdfToJpgController::class, 'index'])
    ->name('pdf2jpg.form');

Route::post('/convert/pdf-to-jpg', [PdfToJpgController::class, 'convert'])
    ->name('pdf2jpg.convert');


Route::get('/convert/png-to-jpg', [PngToJpgController::class, 'index'])
    ->name('png2jpg.form');

Route::post('/convert/png-to-jpg', [PngToJpgController::class, 'convert'])
    ->name('png2jpg.convert');


Route::get('/convert/jpg-to-png', [JpgToPngController::class, 'index'])
    ->name('jpg2png.form');

Route::post('/convert/jpg-to-png', [JpgToPngController::class, 'convert'])
    ->name('jpg2png.convert');


Route::get('/convert/png-to-webp', [PngToWebpController::class, 'index'])
    ->name('png2webp.form');

Route::post('/convert/png-to-webp', [PngToWebpController::class, 'convert'])
    ->name('png2webp.convert');


Route::get('/convert/heic-to-jpg', [HeicToJpgController::class, 'index'])
    ->name('heic2jpg.form');

Route::post('/convert/heic-to-jpg', [HeicToJpgController::class, 'convert'])
    ->name('heic2jpg.convert');

Route::get('/convert/csv-to-excel', [CsvToExcelController::class, 'index'])
    ->name('csv2excel.form');

Route::post('/convert/csv-to-excel', [CsvToExcelController::class, 'convert'])
    ->name('csv2excel.convert');

Route::get('/convert/json-to-excel', [JsonToExcelController::class, 'index'])
    ->name('json2excel.form');

Route::post('/convert/json-to-excel', [JsonToExcelController::class, 'convert'])
    ->name('json2excel.convert');


Route::get('/convert/html-table-to-excel', [HtmlTableToExcelController::class, 'index'])
    ->name('htmltable2excel.form');

Route::post('/convert/html-table-to-excel', [HtmlTableToExcelController::class, 'convert'])
    ->name('htmltable2excel.convert');


Route::get('/convert/excel-to-html', [ExcelToHtmlController::class, 'index'])
    ->name('excel2html.form');

Route::post('/convert/excel-to-html', [ExcelToHtmlController::class, 'convert'])
    ->name('excel2html.convert');
