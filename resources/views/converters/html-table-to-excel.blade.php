@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">HTML Tablo → Excel (XLSX)</h1>

<p class="text-gray-600 mb-6">
    HTML kodu içindeki &lt;table&gt; yapısını otomatik olarak Excel dosyasına dönüştürür.
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
    action="{{ route('htmltable2excel.convert') }}"
    method="POST"
    class="bg-white p-6 rounded shadow max-w-3xl"
>
    @csrf

    <label class="font-semibold">HTML Kodunu Yapıştır:</label>
    <textarea
        name="htmlcode"
        rows="10"
        class="w-full border border-gray-300 rounded p-2 mt-2 mb-4"
        placeholder="<table>...</table>"
        required
    ></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Excel'e Dönüştür
    </button>
</form>

@endsection
