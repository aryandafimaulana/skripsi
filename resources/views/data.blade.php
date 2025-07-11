<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Indikator Ketenagakerjaan Per Provinsi 2024</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    @vite('resources/js/filterData.js')
</head>

<body class=" bg-gray-300">
    <x-header />

    <div class="mx-12 mt-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Indikator Ketenagakerjaan 2024</h1>
        <p class="text-gray-600 text-sm">
            Berikut adalah data per provinsi yang meliputi Tingkat Pengangguran Terbuka (TPT), Lowongan Kerja Terdaftar,
            Rata-rata Lama Sekolah (RLS), Indeks Pembangunan Manusia (IPM), dan Tingkat Partisipasi Angkatan Kerja (TPAK).
        </p>
    </div>

    <!-- Ringkasan Data -->
    <section class=" py-8 mx-12">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Provinsi -->
            <div class="bg-white p-6 rounded-lg shadow text-center border-l-4 border-blue-500">
                <p class="text-sm text-gray-500">Total Provinsi</p>
                <h3 class="text-3xl font-bold text-blue-600">{{ $totalProvinsi }}</h3>
            </div>

            <!-- Rata-rata TPT -->
            <div class="bg-white p-6 rounded-lg shadow text-center border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500">Rata-rata TPT Nasional</p>
                <h3 class="text-3xl font-bold text-yellow-600">{{ number_format($avgTPT, 2) }}%</h3>
            </div>

            <!-- TPT Tertinggi -->
            <div class="bg-white p-6 rounded-lg shadow text-center border-l-4 border-red-500">
                <p class="text-sm text-gray-500">TPT Tertinggi</p>
                <h3 class="text-xl font-bold text-red-600">{{ $highest->provinsi }}</h3>
                <p class="text-2xl">{{ number_format($highest->tpt, 2) }}%</p>
            </div>

            <!-- TPT Terendah -->
            <div class="bg-white p-6 rounded-lg shadow text-center border-l-4 border-green-500">
                <p class="text-sm text-gray-500">TPT Terendah</p>
                <h3 class="text-xl font-bold text-green-600">{{ $lowest->provinsi }}</h3>
                <p class="text-2xl">{{ number_format($lowest->tpt, 2) }}%</p>
            </div>
        </div>
    </section>

    <!-- Filter Container -->
    <div class="bg-white rounded-md px-6 py-4 shadow mx-12 md:mx-12 mb-2 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

            <!-- Search -->
            <div class="w-full md:flex-1">
                <label for="searchInput" class="sr-only">Cari Provinsi</label>
                <div class="relative">
                    <input id="searchInput" type="text" placeholder="Cari provinsi..."
                        class="w-full pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="flex flex-wrap items-center gap-2">
                <select id="filterIndikator"
                    class="py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 w-full lg:w-auto">
                    <option value="">Indikator</option>
                    <option value="tpt">TPT</option>
                    <option value="ipm">IPM</option>
                    <option value="rls">RLS</option>
                    <option value="tpak">TPAK</option>
                    <option value="lowongan_kerja">Lowongan Kerja</option>
                </select>

                <select id="filterKondisi"
                    class="py-2 px-3 text-sm border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 w-full lg:w-auto">
                    <option value="">Kondisi</option>
                    <option value="atas">Di Atas Rata-rata</option>
                    <option value="bawah">Di Bawah Rata-rata</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-2">
                <button id="resetFilter"
                    class="py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-md shadow whitespace-nowrap w-full lg:w-auto">
                    🔄 Reset Filter
                </button>
                <a href="{{ route('export.excel') }}" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-center text-sm rounded-md shadow whitespace-nowrap w-full lg:w-auto">
                    <button>
                        📥 Download Data
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Status -->
    <div id="filterStatus"
        class="text-sm text-gray-700 mx-12 md:mx-12 mb-4 hidden bg-white rounded-md px-4 py-2 border border-gray-200 shadow">
        <p class="mb-1 font-semibold text-gray-800">Filter aktif:</p>
        <div class="flex flex-wrap gap-2">
            <span id="searchStatus" class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded"></span>
            <span id="filterIndikatorStatus" class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded"></span>
        </div>
    </div>


    <div class="relative overflow-x-auto mx-12 mt-4 mb-4 rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Provinsi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tingkat Pengangguran Terbuka (TPT)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lowongan Kerja Terdaftar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Rata-rata Lama Sekolah (RLS)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Indeks Pembangunan Manusia (IPM)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tingkat Partisipasi Angkatan Kerja (TPAK)
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                    data-provinsi="{{ strtolower($row->provinsi) }}"
                    data-tpt="{{ $row->tpt }}"
                    data-ipm="{{ $row->ipm }}"
                    data-rls="{{ $row->rls }}"
                    data-tpak="{{ $row->tpak }}"
                    data-lowongan_kerja="{{ $row->lowongan_kerja }}">

                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->provinsi }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $row->tpt }} %
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->lowongan_kerja }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->rls }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->ipm }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->tpak }} %
                    </td>
                </tr>
                @endforeach
            </tbody>


        </table>
    </div>

    <script>
        window.dataAverages = {};
        window.dataAverages.tpt = <?= json_encode($avgTPT ?? 0) ?>;
        window.dataAverages.ipm = <?= json_encode($avgIPM ?? 0) ?>;
        window.dataAverages.rls = <?= json_encode($avgRLS ?? 0) ?>;
        window.dataAverages.tpak = <?= json_encode($avgTPAK ?? 0) ?>;
        window.dataAverages.lowongan_kerja = <?= json_encode($avgLowongan ?? 0) ?>;
    </script>


</body>

</html>