<?= $this->extend('/layout/base'); ?>
<?= $this->section('content') ?>
<div class="container">
  <div class="card shadow my-5">
    <div class="card-body p-5">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img class="rounded-circle img-fluid mb-4" style="width: 200px; height: 200px;" src="<?= base_url() . '/uploads/foto-profil/' . session()->get('foto_profil') ?>" />
          <?php if (empty(session()->get('level'))) : ?>
            <h5><?= session()->get('nama') ?></h5>
          <?php else : ?>
            <h5><?= session()->get('nama_petugas') ?></h5>
          <?php endif ?>
          <?php if (empty(session()->get('level'))) : ?>
            <span class="d-block">NIK : <?= session()->get('nik') ?></span>
          <?php endif ?>
          <span class="d-block">Nomor Telepon : <?= session()->get('telp') ?></span>
        </div>
        <div class="col-sm-12 text-center mt-2">
          <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#editProfil">
            Edit Profil
          </button>

          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gantiPassword">
            Ganti Password
          </button>
          <hr>
        </div>
        <div class="col-sm-12 text-center">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Profil Modal -->
<div class="modal fade" id="editProfil" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Edit Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/profil/edit" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <input type="hidden" name="id_masyarakat" value="<?= session()->get('id_masyarakat') ?>">
            <div class="col-sm-12">
              <label>Username</label>
              <input type="text" class="form-control" name="username" value="<?= session()->get('username') ?>">
            </div>
            <div class="col-sm-12 mt-2">
              <label>Nama Lengkap</label>
              <input type="text" class="form-control" name="nama" value="<?= (session()->get('level') == null ? session()->get('nama') : session()->get('nama_petugas')) ?>">
            </div>
            <?php if (empty(session()->get('level'))) : ?>
              <div class="col-sm-12 mt-2">
                <label>NIK</label>
                <input type="text" class="form-control" name="nik" value="<?= session()->get('nik') ?>">
              </div>
            <?php endif ?>
            <div class="col-sm-12 mt-2">
              <label>Nomor Telepon</label>
              <input type="text" class="form-control" name="telp" value="<?= session()->get('telp') ?>">
            </div>
            <div class="col-sm-12 mt-2">
              <label>Foto Profil</label>
              <input type="file" class="form-control" name="foto_profil">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Ganti Password Modal -->
<div class="modal fade" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Ganti Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/profil/ganti-password" method="POST">
        <div class="modal-body">
          <label>Password Baru</label>
          <input type="password" name="password" class="form-control" placeholder="Masukkan password baru...">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>