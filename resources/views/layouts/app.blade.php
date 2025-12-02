<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'KunConvert' }}</title>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #d0d0d0; border-radius: 8px; }
    </style>
</head>

<body class="bg-[#f7f7f8] text-gray-800">
    <!-- TOP NAVBAR -->
    <header class="bg-white border-b shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg"></div>
                <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text">
                    KunConvert
                </h1>
            </div>

            <!-- Right items -->
            <div class="flex items-center gap-5">

                <!-- Search -->
                <div class="hidden md:block">
                    <input type="text"
                           placeholder="Ara..."
                           class="px-3 py-2 text-sm border rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 w-52">
                </div>

                <!-- Profile -->
                <div class="w-9 h-9 bg-gray-200 rounded-full"></div>
            </div>

        </div>
    </header>


    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-6 py-10">
        @yield('content')
    </main>

</body>
</html>
