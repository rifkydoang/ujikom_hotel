<?php
require 'koneksi.php';

// cek apakah tombol sudah ditekan
if ( isset($_POST['submit']) ) {

  $username = strtolower($_POST['username']);
  $password = $_POST['password'];
  // var_dump($_POST);

  $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");

  // cek apakah data ada atau tidak / sama atau tidak
  if(mysqli_num_rows($result) === 1) {

    //ambil data untuk mensortir
    $cek = mysqli_fetch_assoc($result);

    session_start();
    $_SESSION['username'] = $username;
    // var_dump($cek);
    // die;
    
    if($cek['level'] == 1){    
      header("Location: ./admin/index.php");
      exit;
    } else if($cek['level'] == 2){
      header("Location: ./resepsionis/pesanan.php");
      exit;
    } else {
      header("Location: index.php");
      $_SESSION['nama_user'] = $cek['nama_user'];
      $_SESSION['email_user'] = $cek['email_user'];
      $_SESSION['no_handphone'] = $cek['no_handphone'];
      exit;
    }
  } else {
    echo
        "
        <script>alert('Password atau Username salah');
        document.location.href = 'login.php';
        </script>
        ";
    exit;
  }
}

session_start();
if(isset($_SESSION['username'])){
  echo "<script>alert('Anda sudah login')</script>";
  header("Location: index.php");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Aplikasi Hotel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="" class="h1"><b>Login</b> Aplikasi</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Silahkan Login</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">

            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>