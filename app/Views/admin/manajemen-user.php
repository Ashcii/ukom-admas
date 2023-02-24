<?= $this->extend('layout/base') ?>
<?= $this->section('content') ?>
<div class="container">
  <div class="row mt-3">
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan') ?>
      </div>
    <?php endif ?>

    <?php if (validation_errors()) : ?>
      <div class="alert alert-danger" role="alert">
        <?= validation_list_errors() ?>
      </div>
    <?php endif ?>
    <h4 style="color: #575860;">REKAPITULASI PENGGUNA</h4>
    <hr>
    <div class="col-sm-4 mb-2">
      <div class="card bg-primary">
        <div class="card-body text-white">
          <div class="d-flex justify-content-between">
            <h5>MASYARAKAT</h5>
            <h5><i class="fa-solid fa-user"></i></h5>
          </div>
          <span class="display-4"><?= $total_masyarakat ?></span>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-2">
      <div class="card bg-warning">
        <div class="card-body text-white">
          <div class="d-flex justify-content-between">
            <h5>PETUGAS</h5>
            <h5><i class="fa-solid fa-user-shield"></i></h5>
          </div>
          <span class="display-4"><?= $total_petugas ?></span>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-2">
      <div class="card bg-success">
        <div class="card-body text-white">
          <div class="d-flex justify-content-between">
            <h5>ADMINISTRATOR</h5>
            <h5><i class="fa-solid fa-user-gear"></i></h5>
          </div>
          <span class="display-4"><?= $total_admin ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5 border-top border-bottom border-2 border-primary">
    <div class="col-sm-12 mt-3">
      <div class="d-flex justify-content-between">
        <h4 style="color: #575860; display: inline;">TABEL MASYARAKAT</h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMasyarakat">
          <i class="fa-solid fa-user-plus"></i> Tambah Masyarakat
        </button>

        <!-- Modal Tambah Masyarakat -->
        <div class="modal fade" id="tambahMasyarakat" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Tambah Masyarakat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/manajemen-user/tambah-masyarakat" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 mb-3">
                      <label>NIK</label>
                      <input type="text" name="nik" placeholder="Masukkan NIK..." class="form-control">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" placeholder="Masukkan nama..." name="nama">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Nomor Telepon</label>
                      <input type="number" class="form-control" placeholder="Masukkan nomor telepon..." name="telp">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Username</label>
                      <input type="text" class="form-control" placeholder="Masukkan username..." name="username">
                    </div>
                    <div class="col-sm-12">
                      <label>Password</label>
                      <input type="password" class="form-control" placeholder="Masukkan password..." name="password">
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
      </div>
      <hr>
      <table class="table table-hover table-striped" id="tb-masyarakat">
        <thead>
          <th>No</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Nomor Telepon</th>
          <th>Edit</th>
          <th>Hapus</th>
        </thead>
        <?php $no = 1 ?>
        <tbody>
          <?php foreach ($masyarakat as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nik'] ?></td>
              <td><?= $row['nama'] ?></td>
              <td><?= $row['telp'] ?></td>
              <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $no ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalEdit<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/masyarakat-edit/<?= $row['id_masyarakat'] ?>" method="POST">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12">
                              <label for="">NIK</label>
                              <input type="text" class="form-control" name="nik" value="<?= $row['nik'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Username</label>
                              <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>">
                            </div>
                            <div class="col-sm-12">
                              <label for="">Nama</label>
                              <input type="text" class="form-control" name="nama" value="<?= $row['nama'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Telepon</label>
                              <input type="number" class="form-control" name="telp" value="<?= $row['telp'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Password</label>
                              <input type="hidden" name="password_sebelum" value="<?= $row['password'] ?>">
                              <input type="password" name="password" class="form-control" placeholder="Masukkan password...">
                              <span class="text-muted">*Kosongkan jika tidak ingin diubah</span>
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
              </td>
              <td>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $no ?>">
                  <i class="fa-solid fa-trash"></i>
                </button>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Peringatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/masyarakat-hapus/<?= $row['id_masyarakat'] ?>" method="POST">
                        <div class="modal-body">
                          Apakah Anda yakin ingin menghapus data <?= $row['nama'] ?>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row mt-5 border-top border-bottom border-2 border-warning">
    <div class="col-sm-12 mt-3">
      <div class="d-flex justify-content-between">
        <h4 style="color: #575860; display: inline;">TABEL PETUGAS</h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPetugas">
          <i class="fa-solid fa-user-plus"></i> Tambah Petugas
        </button>

        <!-- Modal Tambah Masyarakat -->
        <div class="modal fade" id="tambahPetugas" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Tambah Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/manajemen-user/tambah-petugas" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 mb-3">
                      <label>Nama Petugas</label>
                      <input type="text" name="nama_petugas" placeholder="Masukkan nama..." class="form-control">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Nomor Telepon</label>
                      <input type="number" class="form-control" placeholder="Masukkan nomor telepon..." name="telp">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Username</label>
                      <input type="text" class="form-control" placeholder="Masukkan username..." name="username">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Password</label>
                      <input type="password" class="form-control" placeholder="Masukkan password..." name="password">
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
      </div>
      <hr>
      <table class="table table-hover table-striped" id="tb-petugas">
        <thead>
          <th>No</th>
          <th>Nama Petugas</th>
          <th>Nomor Telepon</th>
          <th>Edit</th>
          <th>Hapus</th>
        </thead>
        <tbody>
          <?php $no = 1 ?>
          <?php foreach ($petugas as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nama_petugas'] ?></td>
              <td><?= $row['telp'] ?></td>
              <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#petugasEdit<?= $no ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="petugasEdit<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/petugas-edit/<?= $row['id_petugas'] ?>" method="POST">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12 mt-2">
                              <label for="">Username</label>
                              <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>">
                            </div>
                            <div class="col-sm-12">
                              <label for="">Nama</label>
                              <input type="text" class="form-control" name="nama" value="<?= $row['nama_petugas'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Telepon</label>
                              <input type="number" class="form-control" name="telp" value="<?= $row['telp'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Password</label>
                              <input type="hidden" name="password_sebelum" value="<?= $row['password'] ?>">
                              <input type="password" name="password" class="form-control" placeholder="Masukkan password...">
                              <span class="text-muted">*Kosongkan jika tidak ingin diubah</span>
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
              </td>
              <td>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#petugasHapus<?= $no ?>">
                  <i class="fa-solid fa-trash"></i>
                </button>

                <!-- Modal Hapus -->
                <div class="modal fade" id="petugasHapus<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Peringatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/petugas-hapus/<?= $row['id_petugas'] ?>" method="POST">
                        <div class="modal-body">
                          Apakah Anda yakin ingin menghapus data <?= $row['nama_petugas'] ?>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row mt-5 border-top border-bottom border-2 border-success">
    <div class="col-sm-12 mt-3">
      <div class="d-flex justify-content-between">
        <h4 style="color: #575860; display: inline;">TABEL ADMIN</h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAdmin">
          <i class="fa-solid fa-user-plus"></i> Tambah Admin
        </button>

        <!-- Modal Tambah Masyarakat -->
        <div class="modal fade" id="tambahAdmin" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Tambah Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/manajemen-user/tambah-admin" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-12 mb-3">
                      <label>Nama Petugas</label>
                      <input type="text" name="nama_petugas" placeholder="Masukkan nama..." class="form-control">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Nomor Telepon</label>
                      <input type="number" class="form-control" placeholder="Masukkan nomor telepon..." name="telp">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Username</label>
                      <input type="text" class="form-control" placeholder="Masukkan username..." name="username">
                    </div>
                    <div class="col-sm-12 mb-3">
                      <label>Password</label>
                      <input type="password" class="form-control" placeholder="Masukkan password..." name="password">
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
      </div>
      <hr>
      <table class="table table-hover table-striped" id="tb-admin">
        <thead>
          <th>No</th>
          <th>Nama Petugas</th>
          <th>Nomor Telepon</th>
          <th>Edit</th>
          <th>Hapus</th>
        </thead>
        <tbody>
          <?php $no = 1 ?>
          <?php foreach ($admin as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nama_petugas'] ?></td>
              <td><?= $row['telp'] ?></td>
              <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#adminEdit<?= $no ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="adminEdit<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/petugas-edit/<?= $row['id_petugas'] ?>" method="POST">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-12 mt-2">
                              <label for="">Username</label>
                              <input type="text" class="form-control" name="username" value="<?= $row['username'] ?>">
                            </div>
                            <div class="col-sm-12">
                              <label for="">Nama</label>
                              <input type="text" class="form-control" name="nama" value="<?= $row['nama_petugas'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Telepon</label>
                              <input type="number" class="form-control" name="telp" value="<?= $row['telp'] ?>">
                            </div>
                            <div class="col-sm-12 mt-2">
                              <label for="">Password</label>
                              <input type="hidden" name="password_sebelum" value="<?= $row['password'] ?>">
                              <input type="password" name="password" class="form-control" placeholder="Masukkan password...">
                              <span class="text-muted">*Kosongkan jika tidak ingin diubah</span>
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
              </td>
              <td>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#adminHapus<?= $no ?>">
                  <i class="fa-solid fa-trash"></i>
                </button>

                <!-- Modal Hapus -->
                <div class="modal fade" id="adminHapus<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Peringatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/manajemen-user/petugas-hapus/<?= $row['id_petugas'] ?>" method="POST">
                        <div class="modal-body">
                          Apakah Anda yakin ingin menghapus data <?= $row['nama_petugas'] ?>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>