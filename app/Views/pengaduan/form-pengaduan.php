<?= $this->extend('/layout/base'); ?>
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
<div class="container">
  <div class="row mt-3 text-center">
    <div class="col-sm-12">
      <h4>FORM PENAMBAHAN PENGADUAN BARU</h4>
      <hr>
    </div>
  </div>
  <div class="row">
    <?php if (validation_errors()) : ?>
      <div class="alert alert-danger" role="alert">
        <?= validation_list_errors() ?>
      </div>
    <?php endif ?>
    <form action="/buat-pengaduan/tambah" method="POST" enctype="multipart/form-data">
      <div class="col-sm-12 mb-2">
        <label class="d-block">Bagikan Secara</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="publish" value="anonim">
          <label class="form-check-label">Anonim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="publish" value="publik">
          <label class="form-check-label">Publik</label>
        </div>
      </div>
      <div class="col-sm-12">
        <label>Judul Laporan</label>
        <input type="text" class="form-control" placeholder="Ketik judul laporan anda..." name="judul_laporan">
      </div>
      <div class="col-sm-12 mt-2">
        <label>Isi Laporan</label>
        <textarea name="laporan" class="form-control" cols="30" rows="7" placeholder="Ketik isi laporan anda..."></textarea>
      </div>
      <div class="col-sm-12 mt-2">
        <label>Lokasi Kejadian</label>
        <div class="autocomplete-panel">
          <div id="autocomplete" class="autocomplete-container"></div>
          <input type="hidden" name="lokasi" class="form-control" placeholder="Masukkan lokasi kejadian..." id="lokasi">
        </div>
      </div>
      <div class="col-sm-12 mt-2">
        <label for="formFile">Upload Lampiran Gambar</label>
        <input class="form-control" type="file" name="foto" id="formFile" accept="image/*">
        <hr>
      </div>
      <div class="col-sm-6">
        <a href="/" class="btn btn-primary">Kembali</a>
        <button class="btn btn-primary" type="submit">Tambah Laporan</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('jsfunction'); ?>
<script src="https://unpkg.com/@geoapify/geocoder-autocomplete@1.4.0/dist/index.min.js"></script>

<!-- Autocomplete Pencarian Lokasi API -->
<script>
  const APIKey = "bc23517f02ef4369bd1ac80eee8925bc";
  let autocompleteInput = new autocomplete.GeocoderAutocomplete(
    document.getElementById("autocomplete"),
    APIKey, {
      /* Geocoder options */
      'lang': 'id',
      'placeholder': 'Masukkan lokasi kejadian...',
      'skipIcons': true,
      'text': 'Banten',
      'filter': {
        'countrycode': ['id'],
        'state': ['Banten']
      }
    });

  autocompleteInput.on('select', (location) => {
    document.getElementById('lokasi').value = location.properties.formatted
  })
</script>
<?= $this->endSection(); ?>