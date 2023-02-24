<?= $this->extend('layout/base') ?>
<?= $this->section('content') ?>
<div class="container">
  <div class="row mt-3">
    <h4 style="color:#575860;">DAFTAR PENGADUAN BELUM DITANGANI</h4>
    <hr>
    <div class="col-sm-12">
      <a href="/laporan-belum/xls" class="btn btn-success w-100 mb-4"><i class="fa-solid fa-file-excel me-2"></i>XLS</a>
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
          <?php foreach ($pengaduan as $row) : ?>
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
    </div>
  </div>
</div>
<?= $this->endSection() ?>