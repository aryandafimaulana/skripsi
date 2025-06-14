<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Peta Indikator Ketenagakerjaan</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #map {
            position: absolute;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        .legend-container {
            max-height: 300px;
            overflow-y: auto;
            font-size: 0.8rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            margin-right: 8px;
            border: 1px solid #00000033;
            border-radius: 2px;
        }
    </style>
</head>

<body class="bg-gray-300">
    <x-header />

    <div class="absolute top-20 right-3 z-[1000] flex gap-2">

        <div class="relative w-60">
            <input id="searchProvinsi"
                type="text"
                placeholder="Cari provinsi..."
                class="py-2 px-3 rounded-lg border text-sm w-full shadow"
                autocomplete="off" />
            <ul id="suggestionList"
                class="absolute z-[1001] mt-1 w-full bg-white border rounded shadow hidden max-h-60 overflow-auto text-sm"></ul>
        </div>

        <div class="relative inline-block text-left">
            <button id="dropdownButton" data-dropdown-toggle="dropdownFilter"
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm inline-flex items-center">
                Filter Peta ▼
            </button>

            <div id="dropdownFilter"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 absolute mt-2">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownButton">
                    <li><a href="#" data-filter="tpt" class="block px-4 py-2 hover:bg-gray-100">TPT</a></li>
                    <li><a href="#" data-filter="ipm" class="block px-4 py-2 hover:bg-gray-100">IPM</a></li>
                    <li><a href="#" data-filter="rls" class="block px-4 py-2 hover:bg-gray-100">RLS</a></li>
                    <li><a href="#" data-filter="tpak" class="block px-4 py-2 hover:bg-gray-100">TPAK</a></li>
                    <li><a href="#" data-filter="lowongan" class="block px-4 py-2 hover:bg-gray-100">Lowongan Kerja</a></li>
                    <li><a href="#" data-filter="reset" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Reset Peta</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tombol -->
    <button data-modal-target="hintModal" data-modal-toggle="hintModal"
        class="absolute bottom-5 right-5 z-[1000] bg-blue-600 text-white px-4 py-2 rounded text-sm shadow">
        ❔ Cara Pakai
    </button>

    <!-- Modal (Flowbite atau custom) -->
    <div id="hintModal"
        class="hidden fixed top-0 left-0 right-0 bottom-0 z-[1001] flex items-center justify-center backdrop-blur-sm bg-white/30">
        <div class="bg-white bg-opacity-95 rounded-lg shadow p-6 max-w-lg w-full mx-4">
            <h2 class="text-lg font-semibold mb-2">🧭 Cara Menggunakan Peta</h2>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                <li>Ketik nama provinsi di kolom pencarian.</li>
                <li>Gunakan filter untuk menampilkan data TPT, IPM, dsb.</li>
                <li>Klik pada peta bagian provinsi tertentu untuk melihat detailnya.</li>
                <li>Gunakan tombol Reset yang ada di filter peta untuk mengembalikan peta ke tampilan awal.</li>
            </ul>
            <div class="mt-4 text-right">
                <button data-modal-hide="hintModal"
                    class="text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>




    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const provinceColors = {};
        const legendItems = [];
        let geoLayer;
        let currentLegend;

        const fixedPalette = [
            '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
            '#8c564b', '#e377c2', '#17becf', '#bcbd22', '#7f7f7f',
            '#393b79', '#637939', '#8c6d31', '#843c39', '#7b4173',
            '#a55194', '#6b6ecf', '#9c9ede', '#ce6dbd', '#e7969c',
            '#de9ed6', '#3182bd', '#9e9ac8', '#8c510a', '#d8b365',
            '#5ab4ac', '#01665e', '#c51b7d', '#fdb863', '#80cdc1',
            '#018571', '#dfc27d', '#1b7837', '#762a83', '#af8dc3',
            '#f1a340', '#998ec3'
        ];

        let paletteIndex = 0;

        function assignColor(provKey) {
            if (!provinceColors[provKey]) {
                provinceColors[provKey] = fixedPalette[paletteIndex % fixedPalette.length];
                paletteIndex++;
            }
            return provinceColors[provKey];
        }




        fetch('/map/geojson')
            .then(res => res.json())
            .then(geojson => {
                geoLayer = L.geoJSON(geojson, {
                    style: function(feature) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        if (!provinceColors[name]) {
                            provinceColors[name] = assignColor(name);
                        }
                        return {
                            fillColor: provinceColors[name],
                            weight: 2,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: 0.7,
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        legendItems.push({
                            name: feature.properties.PROVINSI,
                            color: provinceColors[name]
                        });
                        const props = feature.properties;
                        layer.bindPopup(`
    <strong>${props.PROVINSI}</strong><br>
    TPT: ${props.TPT ?? 'N/A'}%<br>
    IPM: ${props.IPM ?? 'N/A'}<br>
    RLS: ${props.RLS ?? 'N/A'} tahun<br>
    Lowongan Kerja: ${props.LOWONGAN_KERJA_TERDAFTAR ?? 'N/A'}<br>
    TPAK: ${props.TPAK ?? 'N/A'}%
`);

                    }
                }).addTo(map);

                showLegend(legendItems);

                const searchInput = document.getElementById('searchProvinsi');
                const suggestionList = document.getElementById('suggestionList');

                let allProvinsi = [];

                // Tunggu geoLayer selesai dimuat
                function collectProvinsiList() {
                    allProvinsi = [];
                    geoLayer.eachLayer(layer => {
                        const provName = layer.feature.properties.PROVINSI.trim();
                        if (!allProvinsi.includes(provName)) {
                            allProvinsi.push(provName);
                        }
                    });
                }

                map.whenReady(collectProvinsiList);

                searchInput.addEventListener('input', () => {
                    const keyword = searchInput.value.trim().toLowerCase();
                    suggestionList.innerHTML = '';

                    if (!keyword) {
                        suggestionList.classList.add('hidden');
                        return;
                    }

                    const matches = allProvinsi.filter(name =>
                        name.toLowerCase().includes(keyword)
                    );

                    if (matches.length === 0) {
                        suggestionList.classList.add('hidden');
                        return;
                    }

                    matches.forEach(match => {
                        const li = document.createElement('li');
                        li.textContent = match;
                        li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        li.addEventListener('click', () => {
                            zoomToProvince(match);
                            searchInput.value = '';
                            suggestionList.classList.add('hidden');
                        });
                        suggestionList.appendChild(li);
                    });

                    suggestionList.classList.remove('hidden');
                });

                searchInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const match = allProvinsi.find(name =>
                            name.toLowerCase() === searchInput.value.trim().toLowerCase()
                        );
                        if (match) {
                            zoomToProvince(match);
                            searchInput.value = '';
                            suggestionList.classList.add('hidden');
                        }
                    }
                });

                document.addEventListener('click', e => {
                    if (!searchInput.contains(e.target) && !suggestionList.contains(e.target)) {
                        suggestionList.classList.add('hidden');
                    }
                });

                function zoomToProvince(provName) {
                    const targetName = provName.trim().toLowerCase();
                    let found = false;

                    geoLayer.eachLayer(layer => {
                        const name = layer.feature.properties.PROVINSI.trim().toLowerCase();
                        if (name === targetName) {
                            const bounds = layer.getBounds();
                            map.fitBounds(bounds, {
                                padding: [20, 20]
                            });

                            // Warnai provinsi yang dicari
                            layer.setStyle({
                                fillColor: '#3498db', // biru atau warna khusus
                                weight: 3,
                                color: 'white',
                                dashArray: '3',
                                fillOpacity: 0.8
                            });

                            if (layer.getPopup()) layer.openPopup();
                            found = true;
                        } else {
                            // Sembunyikan provinsi lainnya (fillOpacity 0)
                            layer.setStyle({
                                fillOpacity: 0
                            });
                        }
                    });

                    if (!found) {
                        alert('Provinsi tidak ditemukan!');
                    }
                }


            });

        function showLegend(items) {
            if (currentLegend) map.removeControl(currentLegend);
            currentLegend = L.control({
                position: 'bottomleft'
            });
            currentLegend.onAdd = function() {
                const div = L.DomUtil.create('div', 'info legend bg-white p-3 rounded shadow-lg legend-container');
                div.innerHTML = '<h4 class="font-semibold mb-2 text-sm">Legenda</h4>';
                items.forEach(item => {
                    div.innerHTML += `
                        <div class="legend-item">
                            <span class="legend-color" style="background:${item.color}"></span>
                            ${item.name}
                        </div>
                    `;
                });
                return div;
            };
            currentLegend.addTo(map);
        }


        document.querySelectorAll('#dropdownFilter a[data-filter]').forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();
                const type = item.dataset.filter;
                applyFilter(type);
            });
        });

        function applyFilter(type) {
            const indicatorMap = {
                tpt: {
                    label: 'TPT',
                    unit: '%',
                    key: 'TPT'
                },
                ipm: {
                    label: 'IPM',
                    unit: '',
                    key: 'IPM'
                },
                rls: {
                    label: 'RLS',
                    unit: ' tahun',
                    key: 'RLS'
                },
                tpak: {
                    label: 'TPAK',
                    unit: '%',
                    key: 'TPAK'
                },
                lowongan: {
                    label: 'Lowongan Kerja',
                    unit: '',
                    key: 'LOWONGAN_KERJA_TERDAFTAR'
                },
            };

            if (type === 'reset') {
                map.setView([-2.5, 118], 5); // ← Posisi awal peta

                const resetLegend = [];

                geoLayer.eachLayer(layer => {
                    const provName = layer.feature.properties.PROVINSI.trim().toLowerCase();
                    if (!provinceColors[provName]) {
                        provinceColors[provName] = assignColor(name);
                    }
                    const color = provinceColors[provName];
                    layer.setStyle({
                        fillColor: color,
                        weight: 2,
                        color: 'white',
                        dashArray: '3',
                        fillOpacity: 0.7,
                    });
                    resetLegend.push({
                        name: layer.feature.properties.PROVINSI,
                        color
                    });
                });

                showLegend(resetLegend);
                return;
            }

            const {
                label,
                unit,
                key
            } = indicatorMap[type];
            const values = [];

            geoLayer.eachLayer(layer => {
                const val = layer.feature.properties[key];
                if (val !== undefined && val !== null && !isNaN(val)) {
                    values.push(parseFloat(val));
                }
            });

            if (values.length === 0) {
                alert(`Tidak ada data ${label}.`);
                return;
            }

            const avg = values.reduce((a, b) => a + b, 0) / values.length;
            const avgFixed = avg.toFixed(2);
            const legendItems = [];

            geoLayer.eachLayer(layer => {
                const props = layer.feature.properties;
                const val = parseFloat(props[key]);
                let color = '#ccc';

                if (!isNaN(val)) {
                    if (type === 'tpt') {
                        // TPT: rendah bagus → hijau
                        if (val < avg) color = '#27ae60'; // hijau
                        else if (val > avg) color = '#e74c3c'; // merah
                    } else {
                        // Lainnya: tinggi bagus → hijau
                        if (val > avg) color = '#27ae60'; // hijau
                        else if (val < avg) color = '#e74c3c'; // merah
                    }
                }


                layer.setStyle({
                    fillColor: color,
                    weight: 2,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7,
                });

                legendItems.push({
                    name: `${props.PROVINSI} (${val}${unit})`,
                    color
                });
            });

            let categoryLegend = [];

            if (type === 'tpt') {
                categoryLegend = [{
                        name: `${label} < ${avgFixed}${unit} (rata-rata nasional)`,
                        color: '#27ae60'
                    },
                    {
                        name: `${label} > ${avgFixed}${unit} (rata-rata nasional)`,
                        color: '#e74c3c'
                    }
                ];
            } else {
                categoryLegend = [{
                        name: `${label} > ${avgFixed}${unit} (rata-rata nasional)`,
                        color: '#27ae60'
                    },
                    {
                        name: `${label} < ${avgFixed}${unit} (rata-rata nasional)`,
                        color: '#e74c3c'
                    }
                ];
            }


            showLegend(categoryLegend);
        }

        document.getElementById('searchProvinsi').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const keyword = this.value.trim().toLowerCase();
                let found = false;

                geoLayer.eachLayer(layer => {
                    const provName = layer.feature.properties.PROVINSI.trim().toLowerCase();
                    if (provName === keyword) {
                        const bounds = layer.getBounds();
                        map.fitBounds(bounds, {
                            padding: [20, 20]
                        });

                        // Opsional: Buka popup
                        if (layer.getPopup()) {
                            layer.openPopup();
                        }

                        found = true;
                    }
                });

                if (!found) {
                    alert('Provinsi tidak ditemukan!');
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>