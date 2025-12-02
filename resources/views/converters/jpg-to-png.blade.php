@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">JPG → PNG Dönüştürücü</h1>

<p class="text-gray-600 mb-6">
    JPG formatındaki görüntüleri kolayca PNG formatına dönüştürün.
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
    action="{{ route('jpg2png.convert') }}" 
    method="POST" 
    enctype="multipart/form-data"
    class="bg-white p-6 rounded shadow max-w-lg"
>
    @csrf

    <label class="font-semibold">JPG Dosyası Seç:</label>
    <input 
        type="file" 
        name="image" 
        class="block mt-2 mb-4 border border-gray-300 rounded p-2 w-full"
        accept=".jpg,.jpeg"
        required
    >

    <button 
        type="submit"
        class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
    >
        PNG'e Dönüştür
    </button>

</form>

@endsection
