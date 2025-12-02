<?php

namespace App\Http\Controllers\Converters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ChatLogConverterController extends Controller
{
    /**
     * Form ekranı (TXT upload)
     */
    public function index()
    {
        return view('converters.chat-txt-to-excel');
    }

    /**
     * TXT → Excel dönüşümü
     */
    public function convert(Request $request)
    {
        // 1) Validasyon
        $request->validate([
            'txtfile' => 'required|file|mimetypes:text/plain,text/x-log,text/x-msdos-batch,application/octet-stream,text/html,text/csv'
            ]);


        // 2) Dosya içeriğini oku
        $content = file_get_contents($request->file('txtfile')->getRealPath());

        // 3) Chat bloklarını ayır
        // "Chat #1", "Chat #2" gibi başlıklara göre bölüyoruz
        $blocks = preg_split('/Chat #\d+/', $content);
        array_shift($blocks); // en baştaki boş kısımı at

        $data = [];

        foreach ($blocks as $b) {
            // Regex ile alanları çek
            preg_match('/Zaman:\s*(.+)/', $b, $m1);
            preg_match('/Sezon:\s*(.+)/', $b, $m2);
            preg_match('/Oturum:\s*(.+)/', $b, $m3);
            preg_match('/Kullanıcı:\s*(.+)/', $b, $m4);
            preg_match('/Geri Bildirim:\s*(.+)/', $b, $m5);

            preg_match('/Kullanıcı Mesajı:\s*(.*?)\nAsistan Yanıtı:/s', $b, $m6);
            preg_match('/Asistan Yanıtı:\s*(.*)/s', $b, $m7);

            $data[] = [
                'Zaman'             => isset($m1[1]) ? trim($m1[1]) : '',
                'Sezon'             => isset($m2[1]) ? trim($m2[1]) : '',
                'Oturum'            => isset($m3[1]) ? trim($m3[1]) : '',
                'Kullanıcı'         => isset($m4[1]) ? trim($m4[1]) : '',
                'Geri Bildirim'     => isset($m5[1]) ? trim($m5[1]) : '',
                'Kullanıcı Mesajı'  => isset($m6[1]) ? trim($m6[1]) : '',
                'Asistan Yanıtı'    => isset($m7[1]) ? trim($m7[1]) : '',
            ];
        }

        // 4) Excel oluştur
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Başlıklar
        $headers = [
            'Zaman', 'Sezon', 'Oturum', 'Kullanıcı', 'Geri Bildirim',
            'Kullanıcı Mesajı', 'Asistan Yanıtı'
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        // İçerik satırları
        $row = 2;
        foreach ($data as $d) {
            $col = 'A';
            foreach ($d as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // 5) Excel’i kullanıcıya download olarak gönder
        $fileName = 'chat_logs_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
