@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Excel → HTML Tablo</h1>

<p class="text-gray-600 mb-6">
    Excel dosyasını HTML tabloya dönüştür. Çıktı copy/paste için hazır olur.
</p>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc ml-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form
    action="{{ route('excel2html.convert') }}"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white p-6 rounded shadow max-w-lg"
>
    @csrf

    <label class="font-semibold">Excel Dosyası Seç:</label>
    <input 
        type="file"
        name="excelfile"
        class="block mt-2 mb-4 border border-gray-300 rounded p-2 w-full"
        required
    >

    <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
        HTML'e Dönüştür
    </button>

</form>

@endsection
