<style>
   #map {
      height: 600px;
      width: 100%;
      border-radius: 8px;
   }
   
   .gm-style-iw {
      color: #333;
   }
   .info-window-content {
      font-size: 14px;
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
                           <option value="<?= htmlspecialchars($u['name_unit']) ?>"><?= htmlspecialchars($u['name_unit']) ?></option>
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

<!-- Load Google Maps API in development mode (No key provided) -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>

<script>
   var lokasiData = <?= $lokasi_json ?>;
   var markers = [];
   var map;

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

   function getPinIcon(color) {
       return {
           path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
           fillColor: color,
           fillOpacity: 1,
           strokeColor: '#000',
           strokeWeight: 1,
           scale: 1,
           labelOrigin: new google.maps.Point(0, -30)
       };
   }

   function initMap() {
      // Center di Bandara Internasional Soekarno-Hatta (CGK)
      var cgk = {lat: -6.125556, lng: 106.655833};

      // Inisialisasi map dengan mode SATELLITE
      map = new google.maps.Map(document.getElementById('map'), {
         zoom: 15,
         center: cgk,
         mapTypeId: 'satellite'
      });

      var infoWindow = new google.maps.InfoWindow();

      // Loop data untuk menambahkan marker
      lokasiData.forEach(function(item) {
         if(item.latitude && item.longitude) {
            var latLng = new google.maps.LatLng(parseFloat(item.latitude), parseFloat(item.longitude));
            var unitName = item.name_unit ? item.name_unit : 'Unknown';
            var markerColor = getUnitColor(unitName);
            
            var marker = new google.maps.Marker({
               position: latLng,
               map: map,
               title: item.nama_perangkat || item.nama_fasilitas,
               icon: getPinIcon(markerColor),
               unit: unitName
            });

            // Konten untuk InfoWindow
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

            marker.addListener('click', function() {
               infoWindow.setContent(contentString);
               infoWindow.open(map, marker);
            });

            markers.push(marker);
         }
      });
   }

   function filterMarkers() {
       var selectedUnit = document.getElementById('unitFilter').value;
       for (var i = 0; i < markers.length; i++) {
           if (selectedUnit === "" || markers[i].unit === selectedUnit) {
               markers[i].setMap(map);
           } else {
               markers[i].setMap(null);
           }
       }
   }
</script>