<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Peta Indikator Ketenagakerjaan</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <!-- Leaflet CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet/dist/leaflet.css"
    />
    <style>
      #map {
        height: 600px;
        width: 100%;
      }
    </style>
</head>



<body class="bg-gray-300 h-full">
    <x-header />

     <main class="container p-6">
        <h1 class="text-2xl font-bold mb-4">Peta Indikator Ketenagakerjaan</h1>
    </main>

    <div id="map" class=" w-full rounded-lg shadow-lg" style="height: 600px;"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
      var map = L.map('map').setView([-2.5, 118], 5);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Contoh warna random untuk tiap provinsi agar berbeda
      function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      }

      const provinceColors = {};

      // Ganti dengan path file GeoJSON provinsi kamu yang sudah ada di public folder
      fetch('/geo/38_Provinsi.json')
        .then(res => res.json())
        .then(data => {
          L.geoJSON(data, {
            style: function(feature) {
              const name = feature.properties.name; // sesuaikan nama properti di geojson
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
            onEachFeature: function(feature, layer) {
              layer.bindPopup(`<strong>${feature.properties.name}</strong>`);
            }
          }).addTo(map);
        })
        .catch(e => console.error('Gagal load GeoJSON:', e));
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
