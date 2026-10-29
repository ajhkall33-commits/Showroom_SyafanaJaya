<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Laporan Pemeliharaan Pencegahan</title>
<style type="text/css">
  /* Reset dan styling tabel */
  .tg {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    font-family: Arial, sans-serif;
    font-size: 14px;
  }
  .tg th, .tg td {
    border: 1px solid black;
    padding: 10px 8px;
    word-break: break-word;
    vertical-align: middle;
    text-align: center;
  }
  .tg th {
    background-color: #f0f0f0;
    font-weight: bold;
  }
  .tg .tg-center {
    text-align: center;
  }
  .tg .tg-left {
    text-align: left;
  }
  /* Logo images */
  .logo-img {
    max-height: 60px;
    width: auto;
    display: block;
    margin: 0 auto;
  }
  /* Foto images */
  .foto-img {
    max-height: 150px;
    width: auto;
    display: block;
    margin: 0 auto;
    border: 1px solid #ccc;
    background: #fff;
  }
  /* TTD Section */
  .ttd-section {
    width: 100%;
    margin-top: 40px;
    border-collapse: collapse;
    font-size: 14px;
  }
  .ttd-section td {
    width: 33.33%;
    text-align: center;
    vertical-align: top;
    padding: 0 15px;
  }
  .ttd-placeholder {
    height: 80px;
    margin-bottom: 5px;
  }
  /* Styling Perintah Kerja */
  .header-perintah-kerja {
    background-color: #fff; /* Background putih */
  }
  .tg-header-img {
    border: none;
  }
</style>
</head>
<body>
<div class="container">

  <table class="tg">
    <!-- Header Perintah Kerja dengan background putih -->
  <thead>
  <tr>
    <th colspan="2" class="tg-center"   style="height:60px; max-width:80px; width:auto; background-color: white; text-align: center; vertical-align: middle; width: 20%;">
      <img class="logo-img" src="<?= ImageLogo('1') ?>" alt="Logo 1" style="max-width: 120px; height: auto; border: 0; display: block; margin: 0 auto; text-align: center" />
    </th>
    <th colspan="3" class="tg-center" style="font-weight:bold; font-size:16px; line-height:1.3; background-color: white; text-align: center; vertical-align: middle; width: 60%;">
      PERINTAH KERJA<br />PEMELIHARAAN PERBAIKAN
    </th>
    <th colspan="2" class="tg-center" style="background-color: white; text-align: center; vertical-align: middle; width: 20%;">
      <img class="logo-img" src="<?= ImageLogo('2') ?>" alt="Logo 2" style="max-width: 120px; height: auto; border: 0; display: block; margin: 0 auto;text-align: center" />
    </th>
  </tr>
</thead>
    <!-- Header Kode Unit, Klasifikasi, Tanggal -->
    <thead>
      <tr>
        <th colspan="2" class="tg-center">Kode Unit</th>
        <th colspan="3" class="tg-center">Klasifikasi</th>
        <th colspan="2" class="tg-center">Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2" class="tg-center"><?= isset(sess()['unit_kode']) ? sess()['unit_kode'] : '' ?></td>
        <td colspan="3" class="tg-center">Corrective Maintenance</td>
        <td colspan="2" class="tg-center"><?= isset($tanggal) ? $tanggal : '' ?></td>
      </tr>
    </tbody>

    <!-- Header Peralatan, Alat, Permasalahan -->
    <thead>
      <tr>
        <th colspan="2"  style="text-align:center,width:50%;"class="tg-center">Peralatan</th>
        <th colspan="2"  style="text-align:center,width:25%;"class="tg-center">Alat</th>
        <th colspan="1"  style="text-align:center"class="tg-center">Permasalahan</th>
        <th colspan="2" style="text-align:center,width:50%;"class="tg-center">Waktu</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($detail)): ?>
        <?php foreach ($detail as $item): ?>
          <tr>
            <td colspan="2" class="tg-left" style="text-align:center,width:50%;"><?= htmlspecialchars($item['nama_fasilitas'] ?? '') ?></td>
            <td colspan="2" class="tg-left" style="text-align:center,width:25%;"><?= htmlspecialchars($item['nama_perangkat'] ?? '') ?></td>
            <td colspan="1" class="tg-left" style="text-align:center;"><?= htmlspecialchars($item['nama_masalah'] ?? '') ?></td>
            <td colspan="2" class="tg-left" style="text-align:center,width:50%;"><?= htmlspecialchars($item['start_time'] ?? '') ?> - <?= htmlspecialchars($item['end_time'] ?? '') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="2" style="text-align:center,width:50%;" class="tg-center">Tidak ada data</td>
          <td colspan="2" style="text-align:center,width:25%;" class="tg-center">Tidak ada data</td>
          <td colspan="1" style="text-align:center;" class="tg-center">Tidak ada data</td>
          <td colspan="2" style="text-align:center,width:50%;" class="tg-center">Tidak ada data</td>
        </tr>
      <?php endif; ?>
    </tbody>

<!-- Foto Before -->
<thead>
  <tr>
    <th colspan="7" class="tg-center" style="text-align: center; padding: 15px; font-size: 18px; font-weight: bold;">Foto Before</th>
  </tr>
</thead>
<tbody>
  <?php if (!empty($gambar)): ?>
    <?php foreach ($gambar as $item): ?>
      <tr>
        <td colspan="7" class="tg-center"   style="height:140px; max-width:140px; border: 1px solid #000000ff;">
          <?php if (!empty($item['foto_before'])): ?>
           <img src="<?= base_url('upload/' . $item['foto_before']) ?>" style="height:140px; max-width:140px; border: 1px solid #ddd;"/>
          <?php else: ?>
            <span style="font-style: italic;">Tidak ada gambar</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="tg-center" style="text-align: center; padding: 20px;">Tidak ada data gambar</td>
    </tr>
  <?php endif; ?>
</tbody>

<!-- Foto After -->
<thead>
  <tr>
    <th colspan="7" class="tg-center"   style="text-align: center; padding: 15px; font-size: 18px; font-weight: bold;">Foto After</th>
  </tr>
</thead>
<tbody>
  <?php if (!empty($gambar)): ?>
    <?php foreach ($gambar as $item): ?>
      <tr>
        <td colspan="7" class="tg-center"  style="height:140px; max-width:140px; border: 1px solid #000000ff;">
          <?php if (!empty($item['foto_after'])): ?>
           <img src="<?= base_url('upload/' . $item['foto_after']) ?>" style="height:140px; max-width:140px; border: 1px solid #ddd;"/>
          <?php else: ?>
            <span style="font-style: italic;">Tidak ada gambar</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="tg-center" style="text-align: center; padding: 20px;">Tidak ada data gambar</td>
    </tr>
  <?php endif; ?>
</tbody>

<!-- Keterangan -->
<thead>
  <tr>
    <th colspan="7" class="tg-center" style="text-align: center; padding: 15px; font-size: 18px; font-weight: bold;">Keterangan</th>
  </tr>
</thead>
<tbody>
  <?php if (!empty($gambar)): ?>
    <?php foreach ($gambar as $item): ?>
      <tr>
        <td colspan="7" class="tg-left" style="white-space: pre-line; background-color: white; text-align: center; padding: 20px; font-size: 16px;">
          <?= isset($item['description']) ? nl2br(htmlspecialchars($item['description'])) : 'Tidak ada keterangan' ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" class="tg-center" style="background-color: white; text-align: center; padding: 20px;">Tidak ada keterangan</td>
    </tr>
  <?php endif; ?>
</tbody>
  </table>

  <!-- TTD SECTION -->
  <table class="ttd-section">
    <tr>
      <td>
        <p><strong>PENGAWAS</strong></p>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($approved_by ?? 'NAMA PENGAWAS') ?></strong>
      </td>
      
      <td>
        <p><strong>KOORDINATOR</strong></p>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></strong>
      </td>
    </tr>
  </table>

</div>
</body>
</html>
