{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - KerjaStat.id</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 min-h-screen">
    <x-header />

    <main class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Selamat Datang di Dashboard</h1>

        <div class="grid gap-6 md:grid-cols-3">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-blue-700 mb-2">Kelola Data</h2>
                <p class="text-sm text-gray-600">Lihat dan kelola data indikator ketenagakerjaan.</p>
                <a href="/kelolaData" class="inline-block mt-4 text-sm text-blue-600 hover:underline">Lihat Data</a>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-green-700 mb-2">Peta Interaktif</h2>
                <p class="text-sm text-gray-600">Visualisasi spasial berdasarkan indikator.</p>
                <a href="/maps" class="inline-block mt-4 text-sm text-green-600 hover:underline">Lihat Peta</a>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-red-700 mb-2">Logout</h2>
                <p class="text-sm text-gray-600">Keluar dari dashboard ini dengan aman.</p>
                <form action="/logout" method="POST" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md shadow">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </main>

    <section class="max-w-7xl mx-auto px-6 mb-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Ringkasan Statistik Utama</h2>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <div class="space-y-4">
                <!-- Total Provinsi -->
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">Total Provinsi</p>
                    <h3 class="text-lg font-semibold text-blue-600">{{ $totalProvinsi }}</h3>
                </div>

                <!-- Rata-rata TPT -->
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">Rata-rata TPT Nasional</p>
                    <h3 class="text-lg font-semibold text-yellow-600">{{ number_format($avgTPT, 2) }}%</h3>
                </div>

                <!-- TPT Tertinggi -->
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">TPT Tertinggi</p>
                    <div class="text-right">
                        <h3 class="text-base font-semibold text-red-600">{{ $highest->provinsi }}</h3>
                        <p class="text-lg">{{ number_format($highest->tpt, 2) }}%</p>
                    </div>
                </div>

                <!-- TPT Terendah -->
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">TPT Terendah</p>
                    <div class="text-right">
                        <h3 class="text-base font-semibold text-green-600">{{ $lowest->provinsi }}</h3>
                        <p class="text-lg">{{ number_format($lowest->tpt, 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>