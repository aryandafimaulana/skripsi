<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KerjaStat.id</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class=" bg-gray-300">
    <x-header />

    <!-- Hero Section -->
    <section class="bg-blue-50 py-16">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-extrabold text-blue-700 mb-4">Visualisasi dan Analisis Faktor Pengangguran Terbuka
                di Indonesia</h2>
            <p class="text-lg text-gray-600 mb-6">
                Sistem Informasi Geografis (SIG) ini menyajikan data pengangguran terbuka tahun 2024, dilengkapi
                analisis faktor-faktor penyebabnya menggunakan metode regresi linear berganda.
            </p>
            <a href="/maps"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">Lihat Peta</a>
        </div>
    </section>

    <!-- Statistik Ringkas -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-6 text-center">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Rata-rata Nasional</p>
                <h3 class="text-3xl font-bold text-blue-700">{{ number_format($avgTPT, 1) }}%</h3>
                <p class="text-gray-600 mt-2">Tingkat Pengangguran Terbuka</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Provinsi Terendah</p>
                <h3 class="text-3xl font-bold text-green-700">{{ number_format($lowest->tpt, 1) }}%</h3>
                <p class="text-gray-600 mt-2">{{ $lowest->provinsi }}</p>
            </div>
            <div class="bg-red-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Provinsi Tertinggi</p>
                <h3 class="text-3xl font-bold text-red-700">{{ number_format($highest->tpt, 1) }}%</h3>
                <p class="text-gray-600 mt-2">{{ $highest->provinsi }}</p>
            </div>
        </div>
    </section>

    <!-- Tentang Sistem -->
    <section id="tentang" class="py-16 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Tentang Sistem</h3>
            <p class="text-gray-600 leading-relaxed">
                Sistem ini dikembangkan dengan metode <strong>Extreme Programming (XP)</strong> untuk menghasilkan
                perangkat lunak yang fleksibel, iteratif, dan fokus pada kebutuhan pengguna. Analisis data dilakukan
                dengan <strong>regresi linear berganda</strong> untuk mengetahui faktor-faktor yang memengaruhi tingkat
                pengangguran terbuka.
            </p>
        </div>
    </section>

</body>

<!-- Footer -->
<footer class="bg-white border-t py-6 text-center text-gray-500 text-sm">
    &copy; 2024 SIG Pengangguran Terbuka. Dibuat oleh Mahasiswa Informatika.
</footer>

</html>
