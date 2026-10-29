<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
   #map {
      height: 600px;
      width: 100%;
      border-radius: 8px;
      z-index: 1;
   }

   .info-window-content {
      font-size: 14px;
      color: #333;
      min-width: 220px;
   }
   .info-window-content h5 {
      margin-top: 0;
      margin-bottom: 10px;
      font-size: 16px;
      font-weight: bold;
      color: #0056b3;
   }
   .info-window-content p {
      margin: 5px 0;
   }
   .btn-gmaps {
      display: inline-block;
      margin-top: 10px;
      padding: 6px 12px;
      background-color: #1a73e8;
      color: #fff !important;
      text-decoration: none;
      border-radius: 4px;
      font-size: 13px;
   }
   .btn-gmaps:hover {
      background-color: #1557b0;
   }

   /* Legenda Unit */
   .legend-control {
      background: rgba(255,255,255,0.92);
      padding: 10px 14px;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      font-size: 12px;
      line-height: 1.6;
      max-height: 250px;
      overflow-y: auto;
   }
   .legend-control h6 {
      margin: 0 0 6px 0;
      font-size: 13px;
      font-weight: bold;
      color: #333;
   }
   .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 2px;
   }
   .legend-color {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 1px solid #555;
      flex-shrink: 0;
   }
</style>

<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-map bg-c-blue"></i>
            <div class="d-inline">
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row mb-3">
               <div class="col-md-4">
                  <select id="unitFilter" class="form-control" onchange="filterMarkers()">
                     <option value="">-- Semua Unit --</option>
                     <?php if(!empty($units)): ?>
                        <?php foreach($units as $u): ?>
                           <option value="<?= htmlspecialchars($u['id_unit']) ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
                        <?php endforeach; ?>
                     <?php endif; ?>
                  </select>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-block">
                        <div id="map"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Leaflet.js - 100% Gratis, Tanpa API Key -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
   var lokasiData = <?= $lokasi_json ?>;
   var markers = [];
   var map;
   var markerLayerGroup;

   // === Tile Layers (Gratis) ===
   var satelliteTile = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
       attribution: '&copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics',
       maxZoom: 22
   });

   var streetTile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
       attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
       maxZoom: 22
   });

   // === Warna Per Unit ===
   var unitColors = {};
   var colorPalette = [
       '#E74C3C', '#3498DB', '#2ECC71', '#F1C40F', '#9B59B6', 
       '#E67E22', '#1ABC9C', '#34495E', '#FF69B4', '#8B4513', 
       '#00FF7F', '#4682B4', '#D35400', '#8E44AD', '#27AE60'
   ];
   var colorIndex = 0;

   function getUnitColor(unitName) {
       if (!unitName) return '#7F8C8D';
       var key = unitName.trim().toLowerCase();
       
       if (unitColors[key]) {
           return unitColors[key];
       }
       
       // Spesifik "unit north visual aid merah"
       if (key.includes('north') && key.includes('visual') && key.includes('aid')) {
           unitColors[key] = '#FF0000';
           return '#FF0000';
       }
       
       var color = colorPalette[colorIndex % colorPalette.length];
       unitColors[key] = color;
       colorIndex++;
       return color;
   }

   // === Buat ikon pin SVG berwarna ===
   function createColoredIcon(color) {
       var svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="41" viewBox="0 0 25 41">' +
           '<path d="M12.5 0C5.6 0 0 5.6 0 12.5C0 21.9 12.5 41 12.5 41S25 21.9 25 12.5C25 5.6 19.4 0 12.5 0z" ' +
           'fill="' + color + '" stroke="#333" stroke-width="1.5"/>' +
           '<circle cx="12.5" cy="12.5" r="5" fill="white" opacity="0.9"/>' +
           '</svg>';

       return L.divIcon({
           html: svgIcon,
           className: '',
           iconSize: [25, 41],
           iconAnchor: [12, 41],
           popupAnchor: [1, -34]
       });
   }

   // === Inisialisasi Peta ===
   // Center di Bandara Internasional Soekarno-Hatta (CGK)
   map = L.map('map', {
       center: [-6.125556, 106.655833],
       zoom: 15,
       maxZoom: 22,
       layers: [satelliteTile] // Default: Satelit
   });

   // Layer control (tombol untuk ganti antara Satelit dan Jalan)
   var baseMaps = {
       "🛰️ Satelit": satelliteTile,
       "🗺️ Peta Jalan": streetTile
   };
   L.control.layers(baseMaps, null, { position: 'topleft' }).addTo(map);

   // === Tambahkan Marker ===
   markerLayerGroup = L.layerGroup().addTo(map);

   lokasiData.forEach(function(item) {
       if (item.latitude && item.longitude) {
           var lat = parseFloat(item.latitude);
           var lng = parseFloat(item.longitude);
           var unitName = item.name_unit ? item.name_unit : 'Unknown';
           var markerColor = getUnitColor(unitName);

           var marker = L.marker([lat, lng], {
               icon: createColoredIcon(markerColor),
               title: item.nama_perangkat || item.nama_fasilitas
           });

           // Simpan data unit di marker
           marker.unitId = item.id_unit ? item.id_unit.toString() : '';

           // Konten popup (sama persis dengan versi Google Maps)
           var contentString = '<div class="info-window-content">' +
               '<h5>' + (item.jenis_perangkat ? item.jenis_perangkat : 'Unknown') + '</h5>' +
               '<p><strong>Fasilitas:</strong> ' + (item.nama_fasilitas ? item.nama_fasilitas : '-') + '</p>' +
               '<p><strong>Perangkat:</strong> ' + (item.nama_perangkat ? item.nama_perangkat : '-') + '</p>' +
               '<p><strong>Terminal:</strong> ' + (item.terminal ? item.terminal : '-') + '</p>' +
               '<p><strong>Unit:</strong> ' + unitName + '</p>' +
               '<p><strong>Koordinat:</strong> ' + item.latitude + ', ' + item.longitude + '</p>' +
               '<a href="https://www.google.com/maps/search/?api=1&query=' + item.latitude + ',' + item.longitude + '" target="_blank" class="btn-gmaps">' +
               '<i class="fa fa-map-marker"></i> Buka di Google Maps' +
               '</a>' +
               '</div>';

           marker.bindPopup(contentString, { maxWidth: 300 });
           marker.addTo(markerLayerGroup);
           markers.push(marker);
       }
   });

   // === Legenda Warna Unit (Dinamis sesuai filter) ===
   var legend = L.control({ position: 'bottomright' });
   var legendDiv = null;

   legend.onAdd = function(mapInstance) {
       legendDiv = L.DomUtil.create('div', 'legend-control');
       updateLegend(); // Isi legenda pertama kali
       return legendDiv;
   };
   legend.addTo(map);

   function updateLegend(filteredUnitId) {
       if (!legendDiv) return;

       legendDiv.innerHTML = '<h6><i class="fa fa-circle"></i> Legenda Unit</h6>';

       // Kumpulkan unit yang sedang tampil di peta
       var visibleUnits = {};
       for (var i = 0; i < markers.length; i++) {
           if (filteredUnitId === undefined || filteredUnitId === "" || markers[i].unitId === filteredUnitId) {
               // Cari nama unit dari lokasiData
               var unitData = lokasiData[i];
               if (unitData) {
                   var unitName = unitData.name_unit ? unitData.name_unit.trim().toLowerCase() : 'unknown';
                   if (!visibleUnits[unitName]) {
                       visibleUnits[unitName] = getUnitColor(unitData.name_unit || 'Unknown');
                   }
               }
           }
       }

       // Render legenda hanya untuk unit yang tampil
       for (var unitKey in visibleUnits) {
           if (visibleUnits.hasOwnProperty(unitKey)) {
               var displayName = unitKey.charAt(0).toUpperCase() + unitKey.slice(1);
               legendDiv.innerHTML += '<div class="legend-item">' +
                   '<span class="legend-color" style="background:' + visibleUnits[unitKey] + '"></span>' +
                   '<span>' + displayName + '</span>' +
                   '</div>';
           }
       }
   }

   // === Filter Marker Per Unit ===
   function filterMarkers() {
       var selectedUnitId = document.getElementById('unitFilter').value;
       var boundsArray = [];

       // Hapus semua marker dari layer group
       markerLayerGroup.clearLayers();

       // Tambahkan kembali marker yang sesuai filter
       for (var i = 0; i < markers.length; i++) {
           if (selectedUnitId === "" || markers[i].unitId === selectedUnitId) {
               markers[i].addTo(markerLayerGroup);
               boundsArray.push(markers[i].getLatLng());
           }
       }

       // Update legenda sesuai filter
       updateLegend(selectedUnitId);

       // Arahkan peta (pan & zoom) khusus untuk Terminal 1, 2, 3
       if (selectedUnitId === "24") {
           // Terminal 1
           map.setView([-6.130616, 106.657519], 17);
           // Ganti ke peta jalan agar terlihat jelas
           map.removeLayer(satelliteTile);
           streetTile.addTo(map);
       } else if (selectedUnitId === "25") {
           // Terminal 2
           map.setView([-6.118742, 106.653412], 17);
           map.removeLayer(satelliteTile);
           streetTile.addTo(map);
       } else if (selectedUnitId === "26") {
           // Terminal 3
           map.setView([-6.113038, 106.666016], 17);
           map.removeLayer(satelliteTile);
           streetTile.addTo(map);
       } else {
           // Kembalikan ke mode Satelit untuk unit selain terminal
           map.removeLayer(streetTile);
           satelliteTile.addTo(map);
           
           if (selectedUnitId !== "" && boundsArray.length > 0) {
               // Zoom ke semua marker unit yang dipilih
               var bounds = L.latLngBounds(boundsArray);
               map.fitBounds(bounds, { padding: [50, 50], maxZoom: 18 });
           } else if (selectedUnitId === "") {
               // Kembali ke posisi awal bandara jika "Semua Unit"
               map.setView([-6.125556, 106.655833], 15);
           }
       }
   }
</script>