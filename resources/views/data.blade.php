<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Indikator Ketenagakerjaan Per Provinsi 2024</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class=" bg-gray-300">
    <x-header />



    <div class="relative overflow-x-auto my-4 mx-12 rounded-lg">
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
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
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

</body>

</html>
