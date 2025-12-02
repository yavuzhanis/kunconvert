@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="mb-10">
    <h1 class="text-4xl font-bold tracking-tight text-gray-900">
        Hoş geldin 👋
    </h1>
    <p class="text-gray-500 text-lg mt-2">
        Kullanmak istediğin dönüştürme aracını hızlıca seçebilirsin.
    </p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm mb-1">Toplam Araç</p>
        <h3 class="text-3xl font-semibold">15</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm mb-1">Bugünkü Dönüşüm</p>
        <h3 class="text-3xl font-semibold">0</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <p class="text-gray-500 text-sm mb-1">Yeni Eklenen Araç</p>
        <h3 class="text-xl font-semibold">TXT → Excel</h3>
    </div>

</div>


<!-- TOOL CATEGORIES  -->
<h2 class="text-2xl font-bold mb-4">Popüler Araçlar</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">

    <!-- CARD -->
    <a href="{{ route('chat.txt2excel.form') }}"
       class="group bg-white p-6 rounded-2xl shadow-sm border hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col">

        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-3xl mb-4
                    group-hover:bg-blue-600 group-hover:text-white transition">
            📄
        </div>

        <h3 class="text-xl font-semibold">Chat TXT → Excel</h3>
        <p class="text-gray-500 text-sm mt-2">
            Chat log dosyalarını otomatik olarak Excel formatına dönüştür.
        </p>

        <div class="mt-4 text-right text-gray-400 group-hover:text-blue-600 transition text-xl">
            →
        </div>
    </a>

</div>


<!-- ALL TOOLS GRID -->
<h2 class="text-2xl font-bold mb-4">Tüm Araçlar</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach([
        ['Excel → CSV', 'excel2csv.form'],
        ['Excel → JSON', 'excel2json.form'],
        ['CSV → Excel', 'csv2excel.form'],
        ['JSON → Excel', 'json2excel.form'],
        ['HTML → Excel', 'htmltable2excel.form'],
        ['Excel → HTML', 'excel2html.form'],
        ['Word → PDF', 'word2pdf.form'],
        ['PDF → Word', 'pdf2word.form'],
        ['PDF → JPG', 'pdf2jpg.form'],
        ['PNG → JPG', 'png2jpg.form'],
        ['JPG → PNG', 'jpg2png.form'],
        ['PNG → WEBP', 'png2webp.form'],
        ['HEIC → JPG', 'heic2jpg.form'],
    ] as $tool)

    <a href="{{ route($tool[1]) }}"
       class="group bg-white p-5 rounded-xl shadow-sm border hover:shadow-lg hover:-translate-y-1 transition flex items-center justify-between">

        <span class="font-medium">{{ $tool[0] }}</span>

        <span class="text-gray-400 group-hover:text-blue-600 transition text-xl">→</span>
    </a>

    @endforeach

</div>

@endsection
