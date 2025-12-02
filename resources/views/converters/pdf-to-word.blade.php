@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">PDF → Word (DOCX) Dönüştürücü</h1>

<p class="text-gray-600 mb-6">
    PDF dosyalarınızı yüksek doğrulukla Word formatına dönüştürün.
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
    action="{{ route('pdf2word.convert') }}" 
    method="POST" 
    enctype="multipart/form-data"
    class="bg-white p-6 rounded shadow max-w-lg"
>
    @csrf

    <label class="font-semibold">PDF Dosyası:</label>
    <input 
        type="file" 
        name="pdffile" 
        class="block mt-2 mb-4 border border-gray-300 rounded p-2 w-full"
        required
    >

    <button 
        type="submit"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
    >
        Word'e Dönüştür
    </button>

</form>

@endsection
