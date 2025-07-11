<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Data Indikator</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    @vite('resources/js/filterData.js')
</head>

<body class="bg-gray-100">
    <x-header />

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Tombol Tambah -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Data Indikator Ketenagakerjaan</h1>
            <button id="btnAdd" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 text-sm">
                + Tambah Data
            </button>
        </div>

        <!-- Notifikasi sukses -->
        @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif


        <section class="overflow-x-auto bg-white rounded shadow px-4 py-4 mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Unggah Data Excel</h2>

            <form action="{{ route('data.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Input File -->
                <div>
                    <label for="file" class="block mb-2 text-sm font-medium text-gray-700">Pilih File Excel (.xlsx / .xls)</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.xls"
                        class="block w-full border border-gray-300 rounded-lg py-2 px-4 text-sm file:bg-blue-100 file:border-none file:text-blue-800 file:font-semibold hover:file:bg-blue-200 transition duration-150"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Pastikan ukuran file di bawah 5MB.</p>
                </div>

                <!-- Tips Box -->
                <div class="bg-gray-50 border-l-4 border-blue-400 p-4 rounded">
                    <h4 class="font-medium text-sm text-blue-700 mb-1">Catatan Upload:</h4>
                    <ul class="text-xs text-gray-700 list-disc list-inside space-y-1">
                        <li>Gunakan format Excel dengan header di baris pertama.</li>
                        <li>Kolom yang dibutuhkan: <code>PROVINSI, TPT, LOWONGAN KERJA, RLS, IPM, TPAK</code></li>
                        <li>Nama provinsi harus dengan huruf kapital.</li>
                        <li>Data yang diupload akan menggantikan seluruh data lama.</li>
                    </ul>
                </div>

                <!-- Contoh Ringkas -->
                <div class="border border-gray-200 rounded-lg overflow-x-auto">
                    <h1 class=" px-2 py-2 ">Contoh Format :</h1>
                    <table class="min-w-full text-xs text-gray-600 table-auto">
                        <thead class="bg-gray-100 text-gray-700 text-center">
                            <tr>
                                <th class="px-4 py-2 whitespace-nowrap">PROVINSI</th>
                                <th class="px-4 py-2 whitespace-nowrap">TPT</th>
                                <th class="px-4 py-2 whitespace-nowrap">LOWONGAN</th>
                                <th class="px-4 py-2 whitespace-nowrap">RLS</th>
                                <th class="px-4 py-2 whitespace-nowrap">IPM</th>
                                <th class="px-4 py-2 whitespace-nowrap">TPAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white text-center">
                                <td class="px-4 py-2 whitespace-nowrap text-left">ACEH</td>
                                <td class="px-4 py-2">5,11</td>
                                <td class="px-4 py-2">2.100</td>
                                <td class="px-4 py-2">8,79</td>
                                <td class="px-4 py-2">72,40</td>
                                <td class="px-4 py-2">64,13</td>
                            </tr>
                            <tr class="bg-gray-50 text-center">
                                <td class="px-4 py-2 whitespace-nowrap text-left">SUMATERA SELATAN</td>
                                <td class="px-4 py-2">6,00</td>
                                <td class="px-4 py-2">1.800</td>
                                <td class="px-4 py-2">8,32</td>
                                <td class="px-4 py-2">70,12</td>
                                <td class="px-4 py-2">62,45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Submit -->
                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-6 rounded-lg transition">
                        ⬆️ Upload dan Ganti Data
                    </button>
                </div>
            </form>
        </section>


        <!-- Filter Container -->
        <div class="bg-white rounded-md px-6 py-4 shadow mb-2 border border-gray-200">
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
            class="text-sm text-gray-700 mb-4 hidden bg-white rounded-md px-4 py-2 border border-gray-200 shadow">
            <p class="mb-1 font-semibold text-gray-800">Filter aktif:</p>
            <div class="flex flex-wrap gap-2">
                <span id="searchStatus" class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded"></span>
                <span id="filterIndikatorStatus" class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded"></span>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Provinsi</th>
                        <th class="px-6 py-3">TPT (%)</th>
                        <th class="px-6 py-3">Lowongan Kerja</th>
                        <th class="px-6 py-3">RLS</th>
                        <th class="px-6 py-3">IPM</th>
                        <th class="px-6 py-3">TPAK (%)</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr class="bg-white border-b hover:bg-gray-50"
                        data-provinsi="{{ strtolower($row->provinsi) }}"
                        data-tpt="{{ $row->tpt }}"
                        data-ipm="{{ $row->ipm }}"
                        data-rls="{{ $row->rls }}"
                        data-tpak="{{ $row->tpak }}"
                        data-lowongan_kerja="{{ $row->lowongan_kerja }}">
                        <td class="px-6 py-4">{{ $row->provinsi }}</td>
                        <td class="px-6 py-4">{{ $row->tpt }}</td>
                        <td class="px-6 py-4">{{ $row->lowongan_kerja }}</td>
                        <td class="px-6 py-4">{{ $row->rls }}</td>
                        <td class="px-6 py-4">{{ $row->ipm }}</td>
                        <td class="px-6 py-4">{{ $row->tpak }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <button class="text-blue-600 hover:underline text-sm btnEdit"
                                data-id="{{ $row->id }}"
                                data-provinsi="{{ $row->provinsi }}"
                                data-tpt="{{ $row->tpt }}"
                                data-lowongan="{{ $row->lowongan_kerja }}"
                                data-rls="{{ $row->rls }}"
                                data-ipm="{{ $row->ipm }}"
                                data-tpak="{{ $row->tpak }}">
                                Edit
                            </button>
                            <form action="{{ route('data.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center bg-white">
                        <td colspan="7" class="px-6 py-4 text-gray-500">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="dataModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg rounded-lg p-6">
                <h2 id="modalTitle" class="text-xl font-semibold mb-4">Tambah Data</h2>
                <form id="dataForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">
                    <input type="hidden" name="id" id="dataId">

                    <div class="grid grid-cols-2 gap-4">
                        <input name="provinsi" id="provinsi" placeholder="Provinsi" class="border rounded px-3 py-2" required>
                        <input name="tpt" id="tpt" placeholder="TPT" type="number" step="0.01" class="border rounded px-3 py-2" required>
                        <input name="ipm" id="ipm" placeholder="IPM" type="number" step="0.01" class="border rounded px-3 py-2" required>
                        <input name="rls" id="rls" placeholder="RLS" type="number" step="0.01" class="border rounded px-3 py-2" required>
                        <input name="tpak" id="tpak" placeholder="TPAK" type="number" step="0.01" class="border rounded px-3 py-2" required>
                        <input name="lowongan_kerja" id="lowongan_kerja" placeholder="Lowongan Kerja" type="number" class="border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end mt-6 gap-2">
                        <button type="button" id="cancelBtn" class="px-4 py-2 border rounded text-gray-700">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const modal = document.getElementById('dataModal');
            const form = document.getElementById('dataForm');
            const btnAdd = document.getElementById('btnAdd');
            const cancelBtn = document.getElementById('cancelBtn');
            const methodField = document.getElementById('methodField');
            const modalTitle = document.getElementById('modalTitle');

            btnAdd.addEventListener('click', () => {
                form.action = "{{ route('data.store') }}";
                methodField.value = 'POST';
                modalTitle.textContent = 'Tambah Data';
                form.reset();
                modal.classList.remove('hidden');
            });

            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            document.querySelectorAll('.btnEdit').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const provinsi = button.dataset.provinsi;
                    const tpt = button.dataset.tpt;
                    const ipm = button.dataset.ipm;
                    const rls = button.dataset.rls;
                    const tpak = button.dataset.tpak;
                    const lowongan = button.dataset.lowongan;

                    form.action = "{{ url('/kelolaData') }}/" + id;
                    methodField.value = 'PUT';
                    modalTitle.textContent = 'Edit Data';

                    document.getElementById('dataId').value = id;
                    document.getElementById('provinsi').value = provinsi;
                    document.getElementById('tpt').value = tpt;
                    document.getElementById('ipm').value = ipm;
                    document.getElementById('rls').value = rls;
                    document.getElementById('tpak').value = tpak;
                    document.getElementById('lowongan_kerja').value = lowongan;

                    modal.classList.remove('hidden');
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

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