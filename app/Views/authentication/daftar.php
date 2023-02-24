<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Login Pengaduan</title>
</head>

<body style="background-image: url('https://absarcade.c21primagroup.com/template/dist/img/login-background-compressed.jpg'); background-size:cover; background-position-y: 50%; min-height: 100vh;">

  <div class="container-fluid">
    <div class="row">
      <div class="d-flex justify-content-center align-items-center" style="margin-top: 4rem;">
        <div class="card shadow pt-4 pb-3" style="width: 500px; border-radius: 8px;">
          <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
              <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif ?>
            <?php if (session()->getFlashdata('pesan')) : ?>
              <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan') ?>
              </div>
            <?php endif ?>
            <form action="" method="POST">
              <div class="d-flex justify-content-center mb-2">
                <h3 class="lead fs-3">Daftar <span style="color: blue;">Pengaduan</span></h3>
              </div>
              <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                  <?= validation_list_errors() ?>
                </div>
              <?php endif ?>
              <div class="row">
                <div class="col-sm-12">
                  <label>NIK</label>
                  <input type="number" class="form-control" style="border-radius: 10px;" name="nik" placeholder="Masukkan NIK anda...">
                </div>
                <div class="col-sm-12 mt-2">
                  <label>Nama</label>
                  <input type="text" class="form-control" style="border-radius: 10px;" name="nama" placeholder="Masukkan nama anda...">
                </div>
                <div class="col-sm-12 mt-2">
                  <label>Nomor Telepon</label>
                  <input type="number" class="form-control" style="border-radius: 10px;" placeholder="Masukkan nomor telepon anda..." name="telp">
                </div>
                <div class="col-sm-12 mt-2">
                  <label>Username</label>
                  <input type="text" class="form-control" style="border-radius: 10px;" name="username" placeholder="Buat username anda...">
                </div>
                <div class="col-sm-6 mt-3">
                  <label>Password</label>
                  <input type="password" class="form-control" style="border-radius: 10px;" name="password" placeholder="Buat password anda...">
                </div>
                <div class="col-sm-6 mt-3">
                  <label>Ulangi Password</label>
                  <input type="password" class="form-control" style="border-radius: 10px;" name="ulang_password" placeholder="Ulangi password...">
                </div>
              </div>
              <hr>
              <div class="col-sm-12 mt-3">
                <button class="btn btn-primary" style="width: 100%; border-radius: 20px;">Daftar</button>
              </div>
              <div class="d-flex justify-content-center pt-4">
                <p class="me-1">Sudah punya akun?</p><a href="/login" style="text-decoration: none;">Login!</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>