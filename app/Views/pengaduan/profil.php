<?= $this->extend('/layout/base') ?>
<?= $this->section('content') ?>
<div class="container">
  <div class="row mt-5">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 text-center">
              <img class="rounded-circle img-fluid mb-4" style="width: 200px; height: 200px;" src="<?= base_url() . '/uploads/foto-profil/' . $profil_data['foto_profil'] ?>" />
              <h5><?= $profil_data['nama'] ?></h5>
            </div>
            <div class="col-sm-3 text-center mt-4">
              <span class="lead">Jumlah Laporan</span>
              <span class="d-block fs-6 lead border-top"><?= $jumlah ?></span>
            </div>
            <div class="col-sm-3 text-center mt-4">
              <span class="lead ">Belum Ditangani</span>
              <span class="d-block fs-6 lead border-top"><?= $belum_ditangani ?></span>
            </div>
            <div class="col-sm-3 text-center mt-4">
              <span class="lead">Proses</span>
              <span class="d-block fs-6 lead border-top"><?= $proses ?></span>
            </div>
            <div class="col-sm-3 text-center mt-4">
              <span class="lead">Selesai</span>
              <span class="d-block fs-6 lead border-top"><?= $selesai ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-sm-12 mb-2">
      <a href="/<?= $profil_data['id_masyarakat'] ?>" class="fs-5 text-black mb-2 me-2">Semua</a>
      <a href="/<?= $profil_data['id_masyarakat'] ?>?status=0" class="fs-5 text-black mb-2 me-2">Belum</a>
      <a href="/<?= $profil_data['id_masyarakat'] ?>?status=proses" class="fs-5 text-black mb-2 me-2">Proses</a>
      <a href="/<?= $profil_data['id_masyarakat'] ?>?status=selesai" class="fs-5 text-black mb-2 me-2">Selesai</a>
    </div>
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <?php
          if ($get_status == '') {
            $data = $pengaduan_all;
          } else {
            $data = $pengaduan;
          }
          ?>
          <?php foreach ($data as $row) : ?>
            <?php
            if ($row['status'] == '0') {
              $status = 'Laporan Belum Ditangani';
            } else if ($row['status'] == 'proses') {
              $status = 'Laporan Diproses';
            } else {
              $status = 'Laporan Selesai';
            }
            ?>
            <div class="user-information">
              <div class="image-profile d-inline-block" style="position: absolute;">
                <?php if ($row['publish'] != 'anonim') : ?>
                  <img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/' . $profil_data['foto_profil'] ?>" style="width: 44px; height: 44px;">
                <?php else : ?>
                  <img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/default.svg' ?>" style="width: 44px; height: 44px;">
                <?php endif ?>
              </div>
              <div class="content" style="margin-left: 3.5rem;">
                <?php if ($row['publish'] != 'anonim') : ?>
                  <span class="d-inline-block me-1"><?= $profil_data['nama'] ?></span>
                <?php else : ?>
                  <span class="d-inline-block me-1">Anonim</span>
                <?php endif ?>
                <span class="d-inline-block text-muted me-1" style="font-size: smaller;">─</span>
                <span class="text-muted" style="font-size: smaller;"><?= $status ?></span>
                <span class="text-muted d-block"><?= longdate_indo($row['tgl_pengaduan']) ?> <?= date('H:i', strtotime($row['jam_pengaduan'])) ?> WIB</span>
              </div>
            </div>
            <div class="content mt-3" style="margin-left: 3.5rem">
              <a href="/detail/<?= $row['id_pengaduan'] ?>" class="fw-bold d-block" style="text-decoration: none;"><?= $row['judul_laporan'] ?></a>
              <span class="text-muted"><?= $row['lokasi_kejadian'] ?></span>
              <p class="mt-2"><?= $row['isi_laporan'] ?></p>
            </div>
            <hr>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>