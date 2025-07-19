<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>KerjaStat.id</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>

<body class="bg-gray-300">
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

    <!-- Alasan Penelitian -->
    <section class="py-12 bg-white">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-white p-6 rounded-lg shadow flex flex-col md:flex-row items-center gap-6">

                <!-- Gambar ilustrasi -->
                <div class="w-full md:w-1/2">
                    <img src="{{ asset('assets/pengangguran.png') }}"
                        alt="Ilustrasi Pengangguran"
                        class="rounded-lg w-full h-auto object-cover">
                </div>

                <!-- Teks alasan -->
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Mengapa Penelitian Ini Dibuat?</h3>
                    <p class="text-gray-700 text-justify leading-relaxed">
                        Tingkat Pengangguran Terbuka (TPT) merupakan indikator penting untuk menilai situasi ketenagakerjaan
                        dan perekonomian suatu wilayah. Penelitian ini bertujuan untuk menganalisis pengaruh faktor-faktor seperti
                        Upah Minimum Provinsi (UMP), Indeks Pembangunan Manusia (IPM), Rata-rata Lama Sekolah (RLS), Tingkat Partisipasi
                        Angkatan Kerja (TPAK), dan jumlah Lowongan Kerja Terdaftar terhadap TPT di Indonesia. Dengan pemahaman ini,
                        diharapkan dapat membantu pengambilan kebijakan yang lebih tepat sasaran dalam menanggulangi pengangguran.
                    </p>
                </div>

            </div>
        </div>
    </section>


    <!-- Statistik Ringkas -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-6 text-center">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Rata-rata Nasional</p>
                <h3 class="text-3xl font-bold text-blue-700">{{ number_format($avgTPT, 1) }}%</h3>
                <p class="text-gray-600 mt-2">Tingkat Pengangguran Terbuka</p>
                <p class="mt-4 text-justify text-xs text-gray-700">
                    TPT adalah persentase angkatan kerja yang sedang mencari pekerjaan namun belum mendapatkan pekerjaan.
                    Semakin tinggi nilai TPT, semakin besar proporsi penduduk yang belum terserap dalam pasar kerja.
                </p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Provinsi Terendah</p>
                <h3 class="text-3xl font-bold text-green-700">{{ number_format($lowest->tpt, 1) }}%</h3>
                <p class="text-gray-600 mt-2">{{ $lowest->provinsi }}</p>
                <p class="mt-4 text-justify text-xs text-gray-700">
                    Provinsi ini menunjukkan tingkat pengangguran yang sangat rendah, yang bisa menjadi indikasi
                    tingginya kesempatan kerja atau kesesuaian antara pendidikan dan kebutuhan pasar tenaga kerja.
                </p>
            </div>
            <div class="bg-red-100 p-6 rounded-lg shadow">
                <p class="text-sm text-gray-500">Provinsi Tertinggi</p>
                <h3 class="text-3xl font-bold text-red-700">{{ number_format($highest->tpt, 1) }}%</h3>
                <p class="text-gray-600 mt-2">{{ $highest->provinsi }}</p>
                <p class="mt-4 text-justify text-xs text-gray-700">
                    TPT yang tinggi menandakan adanya tantangan dalam penyerapan tenaga kerja, mungkin akibat
                    pertumbuhan ekonomi yang tidak seimbang, mismatch keterampilan, atau rendahnya investasi tenaga kerja.
                </p>
            </div>
        </div>
    </section>

    <!-- Definisi Indikator -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Definisi Indikator yang Digunakan</h3>
            <div class="space-y-6 text-justify text-gray-700 text-sm leading-relaxed">
                <p><strong>1. TPT (Tingkat Pengangguran Terbuka):</strong> Persentase angkatan kerja yang sedang aktif mencari pekerjaan tetapi belum mendapatkan pekerjaan. Indikator ini mencerminkan ketidakseimbangan antara pencari kerja dan lapangan kerja yang tersedia.</p>

                <p><strong>2. IPM (Indeks Pembangunan Manusia):</strong> Ukuran komposit dari tiga dimensi utama pembangunan manusia: umur panjang dan sehat, pengetahuan, dan standar hidup layak. IPM menunjukkan kualitas hidup suatu wilayah.</p>

                <p><strong>3. RLS (Rata-rata Lama Sekolah):</strong> Rata-rata tahun yang telah dihabiskan penduduk usia 25 tahun ke atas dalam menempuh pendidikan formal. Menunjukkan tingkat pendidikan masyarakat.</p>

                <p><strong>4. TPAK (Tingkat Partisipasi Angkatan Kerja):</strong> Persentase penduduk usia kerja (15 tahun ke atas) yang aktif dalam pasar tenaga kerja, baik bekerja maupun mencari kerja.</p>

                <p><strong>5. Lowongan Kerja Terdaftar:</strong> Jumlah total lowongan kerja yang tercatat secara resmi di instansi ketenagakerjaan dalam satu tahun, menggambarkan permintaan tenaga kerja yang tersedia.</p>
            </div>
        </div>
    </section>

    <!-- Tentang Sistem -->
    <section id="tentang" class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Tentang Sistem</h3>
            <p class="text-gray-600 leading-relaxed">
                Sistem ini dikembangkan dengan metode <strong>Extreme Programming (XP)</strong> untuk menghasilkan
                perangkat lunak yang fleksibel, iteratif, dan fokus pada kebutuhan pengguna. Analisis data dilakukan
                dengan <strong>regresi linear berganda</strong> untuk mengetahui faktor-faktor yang memengaruhi tingkat
                pengangguran terbuka di Indonesia pada tahun 2024.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-6 text-center text-gray-500 text-sm">
        &copy; 2024 SIG Pengangguran Terbuka. Dibuat oleh Mahasiswa Informatika.
    </footer>

</body>

</html>