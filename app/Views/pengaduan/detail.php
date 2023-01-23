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
          <span class="lh-1 text-muted">Pengaduan dari <a href="" class="text-reset"><?= $pengaduan->nama ?></a></span>
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
                <form action="/detail/edit/<?= $pengaduan->id_pengaduan ?>" method="POST">
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
                        </div>
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