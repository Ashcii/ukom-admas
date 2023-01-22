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
          <h3>Login Pengaduan Masyarakat</h3>
        </div>
        <div class="card-body">
          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
              <?= session()->getFlashdata('error') ?>
            </div>
          <?php endif ?>
          <form action="" method="POST">
            <div class="col-sm-12">
              <label>Username</label>
              <input type="text" class="form-control" name="username">
            </div>
            <div class="col-sm-12 mt-2">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <div class="d-flex justify-content-end mt-2">
              <a href="">Register</a>
            </div>
            <hr>
            <div class="col-sm-12 mt-3">
              <button class="btn btn-primary" style="width: 100%;">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>