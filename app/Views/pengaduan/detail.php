<?= $this->extend('layout/base'); ?>
<?= $this->section('head'); ?>
<link rel="stylesheet" href="https://unpkg.com/@geoapify/geocoder-autocomplete@1.4.0/styles/round-borders.css">
<style>
  .autocomplete-container {
    position: relative;
  }

  .geoapify-autocomplete-input {
    width: 100%;
  }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container mt-3">
  <?php if (validation_errors()) : ?>
    <div class="alert alert-danger" role="alert">
      <?= validation_list_errors() ?>
    </div>
  <?php endif ?>

  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
      <?= session()->getFlashdata('pesan') ?>
    </div>
  <?php endif ?>

  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-10">
          <h5 class="card-title"><?= $pengaduan->judul_laporan ?></h5>
          <span class="text-muted"><?= longdate_indo($pengaduan->tgl_pengaduan) ?> <?= $pengaduan->jam_pengaduan ?> WIB</span>
          <br>
          <span class="lh-1 text-muted">
            Pengaduan dari
            <?php if ($pengaduan->publish == 'anonim') : ?>
              <span>Anonim</span>
            <?php else : ?>
              <a href="" class="text-reset"><?= $pengaduan->nama ?></a>
            <?php endif ?>
          </span>
          <p class="lh-1 text-muted">Lokasi kejadian : <?= $pengaduan->lokasi_kejadian ?></p>
        </div>
        <?php if ($pengaduan_user == 1) : ?>
          <div class="col-sm-2 d-flex justify-content-end">
            <button type="button" class="btn btn-warning" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#editModal">
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
            <button type="button" class="btn btn-danger mx-1" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#hapusModal">
              <i class="fa-solid fa-trash-can"></i>
            </button>
          </div>

          <!-- Modal Hapus -->
          <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Peringatan!</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/detail/hapus/<?= $pengaduan->id_pengaduan ?>" method="POST">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <input type="hidden" value="<?= $pengaduan->foto ?>" name="foto">
                    Apakah anda yakin ingin menghapus laporan pengaduan ini?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Edit-->
          <div class="modal fade modal-lg" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Sunting Laporan</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/detail/edit/<?= $pengaduan->id_pengaduan ?>" method="POST" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <label>Judul Laporan</label>
                        <input type="text" name="judul_laporan" class="form-control" placeholder="Masukkan judul laporan..." value="<?= $pengaduan->judul_laporan ?>">
                      </div>
                      <div class="col-sm-12 mt-2">
                        <label>Isi Laporan</label>
                        <textarea name="isi_laporan" placeholder="Masukkan isi laporan..." class="form-control" cols="30" rows="7"><?= $pengaduan->isi_laporan ?></textarea>
                      </div>
                      <div class="col-sm-12 mt-2">
                        <label>Lokasi Kejadian</label>
                        <div class="autocomplete-panel">
                          <div id="autocomplete" class="autocomplete-container"></div>
                          <input type="hidden" name="lokasi" id="lokasi">
                          <input type="hidden" name="lokasi_sebelum" value="<?= $pengaduan->lokasi_kejadian ?>">
                        </div>
                      </div>
                      <div class="col-sm-12 mt-2">
                        <label>Gambar Kejadian</label>
                        <input type="hidden" name="foto_sebelum" value="<?= $pengaduan->foto ?>">
                        <input type="file" name="foto" class="form-control">
                        <span class="form-text">*Kosongkan jika tidak ingin mengubah gambar</span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endif ?>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img class="img-fluid" src="/uploads/foto-laporan/<?= $pengaduan->foto ?>" alt="" width="600px">
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
    <div class="card-header bg-primary">
      <div class="d-flex justify-content-between">
        <p class="text-white">Status Pengerjaan</p>
        <?php if (session()->get('level') == 'petugas') : ?>
          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahStatus">
            <i class="fa-solid fa-pen-to-square"></i> Ubah Status Laporan
          </button>

          <!-- Modal -->
          <div class="modal fade" id="ubahStatus" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTitleId">Ubah Status Laporan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/detail/ubah-status/<?= $pengaduan->id_pengaduan ?>" method="POST">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <label>Status Laporan Pengerjaan :</label>
                        <select name="status" id="" class="form-select">
                          <option value="0" <?= ($pengaduan->status == '0' ? 'selected' : '') ?>>Laporan Belum Ditangani</option>
                          <option value="proses" <?= ($pengaduan->status == 'proses' ? 'selected' : '') ?>>Pekerjaan Sedang Dalam Proses</option>
                          <option value="selesai" <?= ($pengaduan->status == 'selesai' ? 'selected' : '') ?>>Pekerjaan Sudah Selesai</option>
                        </select>
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
        <?php endif ?>
      </div>
    </div>
    <div class="card-body">
      <?php
      if ($pengaduan->status == '0') {
        $warna = 'bg-secondary';
        $progress = '100';
        $status = 'Laporan Belum Ditangani';
      } else if ($pengaduan->status == 'proses') {
        $warna = 'bg-primary';
        $progress = '50';
        $status = 'Pekerjaan Sedang Dalam Proses';
      } else {
        $warna = 'bg-success';
        $progress = '100';
        $status = 'Pekerjaan Sudah Selesai';
      }
      ?>

      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated <?= $warna ?>" style="width: <?= $progress ?>%"><?= $status ?></div>
      </div>
    </div>
  </div>

  <div class="card mt-2">
    <div class="card-header bg-primary">
      <div class="d-flex justify-content-between">
        <p class="text-white">Tanggapan</p>
        <?php if (session()->get('level') == 'petugas') : ?>
          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#tambahTanggapan">
            <i class="fa-solid fa-plus"></i> Tambah Tanggapan
          </button>

          <!-- Modal Tambah Tanggapan -->
          <div class="modal fade" id="tambahTanggapan" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTitleId">Tambah Tanggapan Baru</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/detail/tambah-tanggapan/<?= $pengaduan->id_pengaduan ?>" method="POST" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <label>Tanggapan Baru</label>
                        <textarea name="tanggapan" rows="3" class="form-control"></textarea>
                      </div>
                      <div class="col-sm-12">
                        <label class="mt-3">Foto Tanggapan</label>
                        <input type="file" value="" name="foto" class="form-control">
                        <span class="form-text">*Kosongkan jika tidak ingin menambahkan foto</span>
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
        <?php endif ?>
      </div>
    </div>
    <div class="card-body">
      <?php $no = 1 ?>
      <?php foreach ($tanggapan as $row) : ?>
        <!-- Modal Hapus Tanggapan -->
        <?php $no++ ?>
        <div class="modal fade" id="hapusTanggapan<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/detail/hapus-tanggapan/<?= $row['id_tanggapan'] ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                  <div class="container-fluid">
                    Apakah Anda yakin ingin menghapus tanggapan ini?
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

        <div class="alert alert-<?= ($row['status'] == 'sistem' ? 'primary' : 'secondary') ?>" role="alert">
          <div class="d-flex justify-content-between">
            <figcaption class="figure-caption mb-1"><?= tgl_indo($row['tgl_pengaduan']) ?> <?= date('H:i', strtotime($row['jam_pengaduan'])) ?> WIB</figcaption>
            <?php if ($row['nama_petugas'] == session()->get('nama_petugas')) : ?>
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusTanggapan<?= $no ?>">
                <i class="fa-solid fa-trash"></i>
              </button>
            <?php endif ?>
          </div>
          <span style="display: block;"><?= $row['tanggapan'] ?></span>
          <?php if ($row['foto'] != '') : ?>
            <img class="img-fluid mt-3" src="<?= base_url() . '/uploads/foto-laporan/' . $row['foto'] ?>" width="400px">
          <?php endif ?>
          <figcaption class="figure-caption mt-2">- Petugas <?= $row['nama_petugas'] ?></figcaption>
        </div>
      <?php endforeach ?>
      <?php if (empty($tanggapan)) : ?>
        <hr>
        <p class="text-center">Tidak Ada Tanggapan Yang Tersedia.</p>
        <hr>
      <?php endif ?>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('jsfunction'); ?>
<script src="https://unpkg.com/@geoapify/geocoder-autocomplete@1.4.0/dist/index.min.js"></script>

<!-- Autocomplete Pencarian Lokasi API -->
<script>
  const APIKey = "bc23517f02ef4369bd1ac80eee8925bc";
  const autocompleteInput = new autocomplete.GeocoderAutocomplete(
    document.getElementById("autocomplete"),
    APIKey, {
      /* Geocoder options */
      'lang': 'id',
      'placeholder': 'Masukkan lokasi kejadian...',
      'value': 'dsa',
      'skipIcons': true,
      'filter': {
        'countrycode': ['id']
      }
    });

  autocompleteInput.on('select', (location) => {
    document.getElementById('lokasi').value = location.properties.formatted
  })
</script>
<?= $this->endSection(); ?>