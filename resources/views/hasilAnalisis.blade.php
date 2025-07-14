<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis Regresi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <x-header />

    <main class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Hasil Analisis Regresi Linear Berganda</h1>

        <!-- Deskripsi Analisis -->
        <section class="mb-6">
            <p class="text-gray-700 text-sm leading-relaxed">
                Analisis ini dilakukan untuk mengetahui faktor-faktor yang paling memengaruhi Tingkat Pengangguran Terbuka (TPT) di Indonesia tahun 2024. Metode yang digunakan adalah regresi linear berganda dengan variabel bebas: Lowongan Kerja Terdaftar, Rata-rata Lama Sekolah (RLS), Indeks Pembangunan Manusia (IPM), dan Tingkat Partisipasi Angkatan Kerja (TPAK).
            </p>
        </section>

        <!-- Tabel Hasil -->
        <div class="overflow-x-auto bg-white rounded shadow mb-6">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Variabel</th>
                        <th class="px-4 py-2">Koefisien</th>
                        <th class="px-4 py-2">Std. Error</th>
                        <th class="px-4 py-2">t-value</th>
                        <th class="px-4 py-2">P-Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="px-4 py-2">Lowongan Kerja Terdaftar</td>
                        <td class="px-4 py-2">0.389</td>
                        <td class="px-4 py-2">0.107</td>
                        <td class="px-4 py-2">3.627</td>
                        <td class="px-4 py-2">0.001</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">RLS 2024</td>
                        <td class="px-4 py-2">0.603</td>
                        <td class="px-4 py-2">0.196</td>
                        <td class="px-4 py-2">3.084</td>
                        <td class="px-4 py-2">0.004</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">IPM 2024</td>
                        <td class="px-4 py-2">-0.455</td>
                        <td class="px-4 py-2">0.182</td>
                        <td class="px-4 py-2">-2.5</td>
                        <td class="px-4 py-2">0.018</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="px-4 py-2">TPAK AGUSTUS</td>
                        <td class="px-4 py-2">-0.558</td>
                        <td class="px-4 py-2">0.132</td>
                        <td class="px-4 py-2">-4.226</td>
                        <td class="px-4 py-2">0.000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Grafik Koefisien -->
        <div class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Visualisasi Koefisien Variabel</h2>
            <canvas id="coefChart" height="250"></canvas>
        </div>

        <!-- Interpretasi -->
        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Interpretasi Hasil</h2>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
                <li><strong>Lowongan Kerja</strong> memiliki koefisien positif dan signifikan (p=0.001), artinya semakin banyak lowongan kerja, semakin tinggi TPT, kemungkinan karena mismatch atau banyaknya pencari kerja tidak sesuai kualifikasi.</li>
                <li><strong>RLS</strong> juga berpengaruh positif signifikan (p=0.004), menunjukkan pendidikan yang lebih tinggi dapat memperbesar ekspektasi kerja sehingga meningkatkan pengangguran terbuka.</li>
                <li><strong>IPM</strong> berpengaruh negatif (p=0.018), artinya daerah dengan IPM tinggi cenderung memiliki TPT yang lebih rendah.</li>
                <li><strong>TPAK</strong> memiliki pengaruh negatif dan sangat signifikan (p=0.000), menunjukkan bahwa partisipasi angkatan kerja tinggi bisa menurunkan TPT karena daya serap kerja yang baik.</li>
            </ul>
        </section>
    </main>

    <script>
        const ctx = document.getElementById('coefChart').getContext('2d');
        const coefChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lowongan', 'RLS', 'IPM', 'TPAK'],
                datasets: [{
                    label: 'Koefisien',
                    data: [0.389, 0.603, -0.455, -0.558],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>