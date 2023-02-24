<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <?= $this->renderSection('head'); ?>
  <title><?= $title ?></title>
</head>

<body class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-dark navbar-expand-lg bg-primary">
    <div class="container">
      <a class="navbar-brand lead" style="font-weight: bolder;" href="/"><i class="fa-solid fa-envelope me-2"></i>AduanID</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Beranda</a>
          </li>
          <?php if (session()->get('isLogin')) : ?>
            <?php if (empty(session()->get('level'))) : ?>
              <li class="nav-item">
                <a class="nav-link" href="/buat-pengaduan">Buat Pengaduan Baru</a>
              </li>
            <?php endif ?>
            <?php if (session()->get('level')) : ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Pengaduan
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/laporan-semua">Total Pengaduan</a></li>
                  <li><a class="dropdown-item" href="/laporan-belum">Belum Ditangani</a></li>
                  <li><a class="dropdown-item" href="/laporan-proses">Pengaduan Diproses</a></li>
                  <li><a class="dropdown-item" href="/laporan-selesai">Pengaduan Selesai</a></li>
                </ul>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a href="/<?= session()->get('id_masyarakat') ?>" class="nav-link">Pengaduan Saya</a>
              </li>
            <?php endif ?>

            <?php if (session()->get('level') == 'admin') : ?>
              <li class="nav-item">
                <a href="/manajemen-user" class="nav-link">Manajemen User</a>
              </li>
            <?php endif ?>
          <?php endif ?>
        </ul>
        <div class="d-flex justify-content-end">
          <?php if (session()->get('isLogin')) : ?>
            <div class="dropdown">
              <img src="<?= base_url() . '/uploads/foto-profil/' . session()->get('foto_profil') ?>" style="width: 35px; height: 35px;" class="rounded rounded-circle img-fluid mx-2">
              <span style="cursor: pointer;" class="text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= (empty(session()->get('level'))) ? session()->get('nama') : session()->get('nama_petugas') ?></span>
              <ul class="dropdown-menu">
                <li><a href="/profil" class="dropdown-item">Profile</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a href="/logout" class="dropdown-item">Logout</a></li>
              </ul>
            </div>
          <?php endif ?>
          <?php if (empty(session()->get('isLogin'))) : ?>
            <a href="/login" class="btn btn-success" style="width: 80px;">Login</a>
          <?php endif ?>
        </div>
      </div>
    </div>
  </nav>

  <?= $this->renderSection('content'); ?>

  <div class="push" style="height: 50px;">

  </div>
  <footer class="text-center pt-3 mt-auto" style="height: 53px; background-color: #63676f;">
    <span style="color: #ececec;">&copy; <?= date('Y') ?> Copyright <a href="https://linktr.ee/ikhsanbskr" style="color: #ececec;">Muhammad Ikhsan</a></span>
  </footer>

  <!-- Javascript Resources -->
  <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://kit.fontawesome.com/0f659efda6.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

  <?= $this->renderSection('jsfunction'); ?>
  <script>
    $(document).ready(function() {
      $('#tb-pengaduan, #tb-masyarakat, #tb-petugas, #tb-admin, #tb-profil').DataTable({
        responsive: true
      });
    });
  </script>
</body>

</html>