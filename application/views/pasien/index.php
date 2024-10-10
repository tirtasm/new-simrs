

<div class="container">
  <?php if ($user['is_active'] == 0): ?>
    <div class="alert alert-danger" role="alert">
      <h5>Perhatian</h5>
      Akun Anda belum diaktivasi oleh petugas. Silakan datang ke loket pendaftaran atau hubungi nomor berikut ini
      <u>08123456789</u> untuk informasi lebih lanjut.
    </div>
  <?php endif ?>

  <div class="container">
    <div class="row text-left">
      <div class="col-12 col-md-4 py-3">
        <a href="<?=base_url('pasien/rawat_inap')?>" class="btn py-3 btn-info w-100">Rawat Inap</a>
      </div>
      <div class="col-12 col-md-4 py-3">
        <a href="<?=base_url('pasien/riwayat_kunjungan')?>" class="btn py-3 btn-info w-100">Riwayat Kunjungan</a>
      </div>
      <div class="col-12 col-md-4 py-3">
        <a href="<?=base_url('pasien/tindakan_medis')?>" class="btn py-3 btn-info w-100">Tindakan Medis</a>
      </div>
    </div>
  
</div>
