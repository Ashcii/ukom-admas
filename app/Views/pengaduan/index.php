<?= $this->extend('/layout/base'); ?>
<?= $this->section('content'); ?>
<div class="container">
  <div class="row mt-2">
    <h4 style="color:#575860;">DAFTAR PENGADUAN YANG DIBUAT</h4>
    <hr>
  </div>
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body text-white bg-primary">
          <h5>JUMLAH PENGADUAN</h5>
          <p class="display-4">25</p>
          <span>Selengkapnya</span>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body text-white bg-warning">
          <h5>BELUM DITANGANI</h5>
          <p class="display-4">25</p>
          <span>Selengkapnya</span>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body text-white bg-info">
          <h5>PENGADUAN DIPROSES</h5>
          <p class="display-4">25</p>
          <span>Selengkapnya</span>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body text-white bg-success">
          <h5>PENGADUAN SELESAI</h5>
          <p class="display-4">25</p>
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
          <th>Tanggal</th>
          <th>Isi Pengaduan</th>
          <th>Status</th>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>24-11-2022</td>
            <td>Ada jalan berlubang dijalan sana</td>
            <td>Selesai</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('jsfunction'); ?>
<script>
  $(document).ready(function() {
    $('#tb-pengaduan').DataTable();
  });
</script>
<?= $this->endSection(); ?>