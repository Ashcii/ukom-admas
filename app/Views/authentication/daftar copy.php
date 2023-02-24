<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Login Masyarakat</title>
</head>

<body>
  <div class="row">
    <div class="d-flex justify-content-center py-5">
      <div class="card shadow" style="width: 500px;">
        <div class="card-header text-center">
          <h3>Buat Akun Pengaduan</h3>
        </div>
        <div class="card-body">
          <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
              <?= validation_list_errors() ?>
            </div>
          <?php endif ?>
          <form action="" method="POST">
            <div class="row">
              <div class="col-sm-12">
                <label>NIK</label>
                <input type="number" class="form-control" name="nik" placeholder="Masukkan NIK anda...">
              </div>
              <div class="col-sm-12 mt-2">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama anda...">
              </div>
              <div class="col-sm-12 mt-2">
                <label>Nomor Telepon</label>
                <input type="number" class="form-control" placeholder="Masukkan nomor telepon anda..." name="telp">
              </div>
              <div class="col-sm-6 mt-2">
                <label>Username</label>
                <input type="text" class="form-control" name="username" placeholder="Buat username anda...">
              </div>
              <div class="col-sm-6 mt-2">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Buat password anda...">
              </div>
            </div>
            <hr>
            <div class="col-sm-12">
              <a href="/login" class="btn btn-secondary">Kembali</a>
              <button class="btn btn-primary">Daftar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>