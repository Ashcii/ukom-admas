<?= $this->extend('/layout/base'); ?>
<?= $this->section('content'); ?>
<div class="container">
  <div class="row mt-2">
    <?php if (session()->getFlashData('pesan')) : ?>
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan') ?>
      </div>
    <?php endif ?>
    <h4 style="color:#575860;">DAFTAR PENGADUAN MASYARAKAT</h4>
    <hr>
  </div>
  <div class="row">
    <div class="col-lg-3 col-6 mb-4">
      <div class="card shadow">
        <div class="card-body text-white bg-primary">
          <h5>JUMLAH PENGADUAN</h5>
          <p class="display-4"><?= $pengaduan_total ?></p>
          <span>Selengkapnya</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="card shadow">
        <div class="card-body text-white bg-warning">
          <h5>BELUM DITANGANI</h5>
          <p class="display-4"><?= $belum_ditangani ?></p>
          <span>Selengkapnya</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6"">
      <div class=" card shadow">
      <div class="card-body text-white bg-info">
        <h5>PENGADUAN PROSES</h5>
        <p class="display-4"><?= $pengaduan_proses ?></p>
        <span>Selengkapnya</span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="card shadow">
      <div class="card-body text-white bg-success">
        <h5>PENGADUAN SELESAI</h5>
        <p class="display-4"><?= $pengaduan_selesai ?></p>
        <span>Selengkapnya</span>
      </div>
    </div>
  </div>
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

  <div class="col-sm-12 mt-2">
    <table class="table table-striped" id="tb-pengaduan">
      <thead>
        <th>No</th>
        <th>Pelapor</th>
        <th>Tanggal</th>
        <th>Isi Pengaduan</th>
        <th>Status</th>
      </thead>
      <tbody>
        <?php $no = 1 ?>
        <?php foreach ($pengaduan as $row) : ?>
          <?php if ($row->publish == 'anonim') {
            $nama = 'Anonim';
          } else {
            $nama = $row->nama;
          }
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td>
              <?php if ($nama != 'Anonim') : ?>
                <a href="/<?= $row->id_masyarakat ?>" style="color: black;"><?= $nama ?></a>
              <?php else : ?>
                <?= $nama ?>
              <?php endif ?>
            </td>
            <td><?= date('d-M-Y', strtotime($row->tgl_pengaduan)) ?></td>
            <td><a href="/detail/<?= $row->id_pengaduan ?>" class="text-reset"><?= $row->judul_laporan ?></a></td>
            <td><?= $row->status ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?= $this->endSection(); ?>