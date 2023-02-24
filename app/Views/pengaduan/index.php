<?= $this->extend('/layout/base'); ?>
<?= $this->section('content'); ?>
<div class="container">
  <div class="row mt-3">
    <?php if (session()->getFlashData('pesan')) : ?>
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan') ?>
      </div>
    <?php endif ?>
    <h4 style="color:#575860;">DAFTAR PENGADUAN MASYARAKAT</h4>
    <hr>
  </div>
  <div class="row">
    <?php if (empty(session()->get('level'))) : ?>
      <div class="col-lg-3 col-6 mb-4">
        <a href="/" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-primary rounded">
              <h5>JUMLAH PENGADUAN</h5>
              <p class="display-4"><?= $pengaduan_total ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/?status=0" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-danger rounded">
              <h5>BELUM DITANGANI</h5>
              <p class="display-4"><?= $belum_ditangani ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/?status=proses" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-info rounded">
              <h5>PENGADUAN PROSES</h5>
              <p class="display-4"><?= $pengaduan_proses ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/?status=selesai" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-success rounded">
              <h5>PENGADUAN SELESAI</h5>
              <p class="display-4"><?= $pengaduan_selesai ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
    <?php else : ?>
      <div class="col-lg-3 col-6 mb-4">
        <a href="/laporan-semua" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-primary rounded">
              <h5>JUMLAH PENGADUAN</h5>
              <p class="display-4"><?= $pengaduan_total ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/laporan-belum" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-danger rounded">
              <h5>BELUM DITANGANI</h5>
              <p class="display-4"><?= $belum_ditangani ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/laporan-proses" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-info rounded">
              <h5>PENGADUAN PROSES</h5>
              <p class="display-4"><?= $pengaduan_proses ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-6">
        <a href="/laporan-selesai" style="text-decoration: none;">
          <div class="card shadow">
            <div class="card-body text-white bg-success rounded">
              <h5>PENGADUAN SELESAI</h5>
              <p class="display-4"><?= $pengaduan_selesai ?></p>
              <span>Selengkapnya</span>
            </div>
          </div>
        </a>
      </div>
    <?php endif ?>
  </div>
  <div class="row">
    <div class="col-sm-12 mt-5">
      <?php if (session()->get('isLogin')) : ?>
        <a href="/buat-pengaduan" class="btn btn-primary">BUAT PENGADUAN BARU</a>
      <?php endif ?>
      <?php if (empty(session()->get('isLogin'))) : ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLogin">
          BUAT PENGADUAN BARU
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sudah memiliki akun?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                Kamu belum memiliki akun, silahkan login terlebih dahulu untuk membuat pengaduan baru.
                <br>
                <a href="/login" class="btn btn-primary mt-3" style="width: 100%;">Login</a>
              </div>
            </div>
          </div>
        </div>
      <?php endif ?>
    </div>

    <div class="col-sm-12">
      <?php if ($getStatus == '' && empty(session()->get('level'))) : ?>
        <?php foreach ($pengaduan as $row) : ?>
          <?php
          if ($row['status'] == '0') {
            $status = 'Laporan Belum Ditangani';
          } else if ($row['status'] == 'proses') {
            $status = 'Laporan Diproses';
          } else {
            $status = 'Laporan Selesai';
          }
          ?>
          <hr>
          <div class="user-information">
            <div class="image-profile d-inline-block" style="position: absolute;">
              <?php if ($row['publish'] != 'anonim') : ?>
                <a href="/<?= $row['id_masyarakat'] ?>"><img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/' . $row['foto_profil'] ?>" style="width: 44px; height: 44px;"></a>
              <?php else : ?>
                <img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/default.svg' ?>" style="width: 44px; height: 44px;">
              <?php endif ?>
            </div>
            <div class="content" style="margin-left: 3.5rem;">
              <?php if ($row['publish'] != 'anonim') : ?>
                <a href="/<?= $row['id_masyarakat'] ?>" class="d-inline-block me-1"><?= $row['nama'] ?></a>
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
        <?php echo $pager->simpleLinks('halaman', 'bootstrap_pagination'); ?>
      <?php else : ?>
        <?php foreach ($pengaduanStatus as $row) : ?>
          <?php
          if ($row['status'] == '0') {
            $status = 'Laporan Belum Ditangani';
          } else if ($row['status'] == 'proses') {
            $status = 'Laporan Diproses';
          } else {
            $status = 'Laporan Selesai';
          }
          ?>
          <hr>
          <div class="user-information">
            <div class="image-profile d-inline-block" style="position: absolute;">
              <?php if ($row['publish'] != 'anonim') : ?>
                <a href="/<?= $row['id_masyarakat'] ?>"><img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/' . $row['foto_profil'] ?>" style="width: 44px; height: 44px;"></a>
              <?php else : ?>
                <img class="img-fluid rounded-circle" src="<?= base_url() . '/uploads/foto-profil/default.svg' ?>" style="width: 44px; height: 44px;">
              <?php endif ?>
            </div>
            <div class="content" style="margin-left: 3.5rem;">
              <?php if ($row['publish'] != 'anonim') : ?>
                <a href="/<?= $row['id_masyarakat'] ?>" class="d-inline-block me-1"><?= $row['nama'] ?></a>
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
        <?php echo $pager->simpleLinks('halaman_filter', 'bootstrap_pagination'); ?>
      <?php endif ?>
      <?php if (session()->get('level')) : ?>
        <table class="table table-striped" id="tb-pengaduan">
          <thead>
            <th>No</th>
            <th>Pelapor</th>
            <th>NIK</th>
            <th>Tanggal</th>
            <th>Isi Pengaduan</th>
            <th>Status</th>
          </thead>
          <tbody>
            <?php $no = 1 ?>
            <?php foreach ($pengaduanAdmin as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><a href="/<?= $row['id_masyarakat'] ?>" style="text-decoration: none;"><?= $row['nama'] ?></a></td>
                <td><?= $row['nik'] ?></td>
                <td><?= date('d-M-Y', strtotime($row['tgl_pengaduan'])) ?></td>
                <td><a href="/detail/<?= $row['id_pengaduan'] ?>" class="text-reset"><?= $row['judul_laporan'] ?></a></td>
                <td><?= $row['status'] ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif ?>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>