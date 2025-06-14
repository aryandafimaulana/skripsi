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
        html, body { margin: 0; padding: 0; height: 100%; }
        #map { position: absolute; top: 64px; left: 0; right: 0; bottom: 0; z-index: 0; }
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
        .filter-btn {
            position: absolute;
            top: 80px;
            left: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-gray-300">
    <x-header />

    <button id="filterTPT" class="filter-btn bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm">
        Tampilkan Berdasarkan TPT
    </button>

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

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        

        fetch('/map/geojson')
            .then(res => res.json())
            .then(geojson => {
                geoLayer = L.geoJSON(geojson, {
                    style: function (feature) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        if (!provinceColors[name]) {
                            provinceColors[name] = getRandomColor();
                        }
                        return {
                            fillColor: provinceColors[name],
                            weight: 2,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: 0.7,
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        const name = feature.properties.PROVINSI.trim().toLowerCase();
                        legendItems.push({
                            name: feature.properties.PROVINSI,
                            color: provinceColors[name]
                        });
                        layer.bindPopup(`<strong>${feature.properties.PROVINSI}</strong>`);
                    }
                }).addTo(map);

                showLegend(legendItems);
            });

        function showLegend(items) {
            if (currentLegend) map.removeControl(currentLegend);
            currentLegend = L.control({ position: 'bottomleft' });
            currentLegend.onAdd = function () {
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

        document.getElementById('filterTPT').addEventListener('click', () => {
            fetch('/map/tpt')
                .then(res => res.json())
                .then(data => {
                    const tptMap = {};
                    data.forEach(item => {
                        tptMap[item.provinsi.trim().toLowerCase()] = parseFloat(item.tpt);
                    });

                    const values = Object.values(tptMap);
                    const avg = values.reduce((a, b) => a + b, 0) / values.length;

                    const legendTPT = [];

                    geoLayer.eachLayer(layer => {
                        const name = layer.feature.properties.PROVINSI.trim().toLowerCase();
                        const tpt = tptMap[name];

                        let color = '#ccc';
                        if (tpt > avg) color = '#e74c3c';       // hijau
                        else if (tpt == avg) color = '#f39c12'; // oranye
                        else if (tpt < avg) color = '#27ae60';  // merah

                        layer.setStyle({
                            fillColor: color,
                            weight: 2,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: 0.7,
                        });

                        legendTPT.push({ name: layer.feature.properties.PROVINSI + ` (${tpt}%)`, color });
                    });

                    showLegend(legendTPT);
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>