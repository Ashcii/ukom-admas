<?= $this->extend('layout/base'); ?>
<?= $this->section('content'); ?>
<div class="container mt-3">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-10">
          <h5 class="card-title"><?= $pengaduan->judul_laporan ?></h5>
          <span class="text-muted"><?= longdate_indo($pengaduan->tgl_pengaduan) ?> <?= $pengaduan->jam_pengaduan ?> WIB</span>
          <br>
          <span class="lh-1 text-muted">Pengaduan dari <a href="" class="text-reset"><?= $pengaduan->nama ?></a></span>
          <p class="lh-1 text-muted">Lokasi pengaduan : <?= $pengaduan->lokasi_kejadian ?></p>
        </div>
        <div class="col-sm-2 d-flex justify-content-end">
          <button class="btn btn-warning" style="height: 40px;"><i class="fa-regular fa-pen-to-square"></i></button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img src="/uploads/foto-laporan/<?= $pengaduan->foto ?>" alt="" width="600px">
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <?= $pengaduan->isi_laporan ?>
        </div>
      </div>
    </div>
  </div>
  <hr>

  <div class="card mt-2">
    <div class="card-header bg-primary text-white">
      <p>Status Pengerjaan</p>
    </div>
    <div class="card-body">
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%">Laporan sedang ditangani</div>
      </div>
    </div>
  </div>

  <div class="card mt-2">
    <div class="card-header bg-primary text-white">
      <p>Tanggapan</p>
    </div>
    <div class="card-body">
      <div class="alert alert-primary" role="alert">
        Sabar ya pak! - Ikhsan
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>