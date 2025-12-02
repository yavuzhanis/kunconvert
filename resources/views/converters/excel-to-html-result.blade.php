@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Excel → HTML Tablo (Sonuç)</h1>

<p class="text-gray-600 mb-4">Aşağıdaki HTML kodunu kopyalayabilirsiniz:</p>

<textarea 
    class="w-full h-64 border border-gray-300 p-3 rounded"
>{{ $html }}</textarea>

<p class="text-gray-600 mt-4 mb-2">Önizleme:</p>

<div class="overflow-auto bg-white p-4 rounded shadow">
    {!! $html !!}
</div>

@endsection
