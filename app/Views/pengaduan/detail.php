<?= $this->extend('layout/base'); ?>
<?= $this->section('content'); ?>
<div class="container mt-2">
  <div class="card">
    <div class="card-header">
      <h5 class="card-title"><?= $pengaduan->judul_laporan ?></h5>
      <span class="text-muted"><?= longdate_indo($pengaduan->tgl_pengaduan) ?></span>
      <br>
      <span class="lh-1 text-muted">Pengaduan dari <a href="" class="text-reset"><?= $pengaduan->nama ?></a></span>
      <p class="lh-1 text-muted">Lokasi pengaduan : <?= $pengaduan->lokasi_kejadian ?></p>
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

  <div class="card mt-2">
    <div class="card-header">
      <p>Status Pengerjaan</p>
    </div>
    <div class="card-body">
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%">Laporan sedang ditangani</div>
      </div>
    </div>
  </div>

  <div class="card mt-2">
    <div class="card-header">
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