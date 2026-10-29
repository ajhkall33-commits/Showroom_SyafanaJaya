<!-- GAMBAR PENGUKURAN -->
<?php
// Cek apakah ada gambar pengukuran
$hasGambarPengukuran = false;
$allGambar = [];

// Kumpulkan semua gambar dari semua fasilitas
foreach ($fasilitas as $item) {
    if (!empty($item['gambar_pengukuran'])) {
        foreach ($item['gambar_pengukuran'] as $gambar) {
            $allGambar[] = [
                'gambar' => $gambar['nama_gambar_pengukuran'],
                'nama_fasilitas' => !empty($gambar['nama_fasilitas']) ? $gambar['nama_fasilitas'] : $item['nama_fasilitas'],
                'fasilitas_id' => $item['id_fasilitas'] ?? null
            ];
        }
        $hasGambarPengukuran = true;
    }
}

if ($hasGambarPengukuran): ?>
<div class="gambar-pengukuran-section" style="border: 1px solid #000000;">
  <style>
    @media print {
      .gambar-pengukuran-section {
        page-break-inside: avoid;
      }
      .gambar-pengukuran-table td {
        page-break-inside: avoid;
      }
      .gambar-container {
        page-break-inside: avoid;
      }
      .gambar-item {
        page-break-inside: avoid;
        page-break-after: auto;
      }
    }
    
    .gambar-cell {
        width: 50%;
        padding: 15px;
        vertical-align: top;
    }
    
    @media print {
      .gambar-cell {
        width: 50% !important;
      }
    }
  </style>
  
  <table class="gambar-pengukuran-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
      <th colspan="2" style="text-align: center; padding: 20px; font-size: 18px; border-radius: 0;">
        DOKUMENTASI HASIL PENGUKURAN
      </th>
    </tr>
    
    <?php
    if (!empty($allGambar)): 
        $gambarCounter = 0;
        
        // Loop melalui semua gambar
        for ($i = 0; $i < count($allGambar); $i += 2):
            // Baris baru setiap 2 gambar
            echo '<tr class="gambar-item">';
            
            // Gambar 1
            if (isset($allGambar[$i])):
                $gambar1 = $allGambar[$i];
                $image_path1 = 'upload/gambar_pengukuran/'.$gambar1['gambar'];
                $full_path1 = base_url($image_path1);
    ?>
            <td class="gambar-cell" style="width: 50%; padding: 15px; vertical-align: top; border: none; page-break-inside: avoid;">
              <div class="gambar-container" style="text-align: center; margin: 0 auto; border: 2px solid #000; border-radius: 0; padding: 0;">
                <div style="margin: 0; padding: 0;">
                  <img src="<?php echo $full_path1; ?>" 
                       style="width: 100%; height: auto; 
                              border: none; border-radius: 0; padding: 0;
                              background-color: white; display: block; max-width: 100%; height: 250px; object-fit: contain;"
                       onerror="this.src='<?php echo base_url("assets/img/default.jpg"); ?>';" 
                       alt="Gambar Pengukuran - <?php echo htmlspecialchars($gambar1['nama_fasilitas']); ?>" />
                </div>
                <div style="padding: 15px; margin: 0; background-color: white; border-radius: 0; border-top: 2px solid #000; text-align: left;">
                  <div style="font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #000;">
                    <?php echo htmlspecialchars($gambar1['nama_fasilitas']); ?>
                  </div>
                  <div style="font-size: 14px; color: #666;">
                    Gambar <?php echo ($i + 1); ?>
                  </div>
                </div>
              </div>
            </td>
    <?php
            endif;
            
            // Gambar 2
            if (isset($allGambar[$i + 1])):
                $gambar2 = $allGambar[$i + 1];
                $image_path2 = 'upload/gambar_pengukuran/'.$gambar2['gambar'];
                $full_path2 = base_url($image_path2);
    ?>
            <td class="gambar-cell" style="width: 50%; padding: 15px; vertical-align: top; border: none; page-break-inside: avoid;">
              <div class="gambar-container" style="text-align: center; margin: 0 auto; border: 2px solid #000; border-radius: 0; padding: 0;">
                <div style="margin: 0; padding: 0;">
                  <img src="<?php echo $full_path2; ?>" 
                       style="width: 100%; height: auto; 
                              border: none; border-radius: 0; padding: 0;
                              background-color: white; display: block; max-width: 100%; height: 250px; object-fit: contain;"
                       onerror="this.src='<?php echo base_url("assets/img/default.jpg"); ?>';" 
                       alt="Gambar Pengukuran - <?php echo htmlspecialchars($gambar2['nama_fasilitas']); ?>" />
                </div>
                <div style="padding: 15px; margin: 0; background-color: white; border-radius: 0; border-top: 2px solid #000; text-align: left;">
                  <div style="font-weight: bold; font-size: 16px; margin-bottom: 5px; color: #000;">
                    <?php echo htmlspecialchars($gambar2['nama_fasilitas']); ?>
                  </div>
                  <div style="font-size: 14px; color: #666;">
                    Gambar <?php echo ($i + 2); ?>
                  </div>
                </div>
              </div>
            </td>
    <?php
            elseif (isset($allGambar[$i])):
                // Jika hanya ada 1 gambar di baris terakhir
                echo '<td class="gambar-cell" style="width: 50%; padding: 15px; vertical-align: top; border: none;"></td>';
            endif;
            
            echo '</tr>';
        endfor;
    else:
    ?>
    <tr>
      <td colspan="2" style="text-align: center; padding: 50px; color: #999; border: none;">
        <em style="font-size: 16px;">Tidak ada gambar pengukuran</em>
      </td>
    </tr>
    <?php endif; ?>
  </table>
</div>
<?php endif; ?>