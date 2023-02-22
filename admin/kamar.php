<?php
require '../koneksi.php';
require 'functions.php';

// cek apakah tombol ditekan
if (isset($_POST['tambah'])) {

    // cek apakah data berhasil ditambahkan atau tidak
    if( tambahKamar($_POST) > 0){
      echo "<script>alert('Data berhasil ditambahkan');'</script>";
    } else {
      echo "<script>alert('Data gagal ditambahkan');'</script>";
    }
}
// cek apakah tombol yang ditekan edit
if( isset( $_POST['edit'] ) ) {

  if( editKamar($_POST) > 0){
    echo "<script>alert('Data berhasil diedit');'</script>";
  } else {
    echo "<script>alert('Data gagal diedit');'</script>";
  }
}
// cek apakah tombol yang ditekan apus
if (isset($_GET['id_kamar'])) {
  if( hapusKamar($_GET['id_kamar']) > 0){
    echo "<script>alert('Data berhasil dihapus');'</script>";
  } else {
    echo "<script>alert('Data gagal dihapus');'</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi UKK 2023 | Pemesanan Hotel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <a href="../admin/index.php" class="navbar-brand">
          <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Hotel Hebat</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="kamar.php" class="nav-link"> Data Kamar</a>
            </li>
            <li class="nav-item">
              <a href="fasilitas.php" class="nav-link">Fasilitas</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="login-register">
      <?php session_start();
      if(isset($_SESSION['username']) && !empty($_SESSION['username']) )
      {?>
        <a href="logout.php">Logout</a>
      <?php }else{ ?>
          <a href="login.php">Login</a>
          <div class="garis"></div>
          <a href="register.php">Register</a>
      <?php } ?>
      </div>
    </nav>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-white">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Kamar</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content bg-white">
        <div class="container">
          <div class="col-md-12">
            <div class="card card-outline card-info">
              <div class="card-header">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah">Tambah</button>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>No Kamar</th>
                      <th>Foto</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT * FROM kamar ORDER BY id_kamar ASC";
                    $result = mysqli_query($koneksi, $query);
                    if (!$result) {
                      die("Query Error: ".mysqli_errno($koneksi). " - ".mysqli_error($koneksi));
                    }

                    $no = 1;

                    while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <tr>
                        <td><?php echo "$no"; ?></td>
                        <td><?php echo $row['nama_kamar']; ?></td>
                        <td>
                          <img class="d-block" src="gambar/<?php echo $row['gambar']; ?>" width="200" height="200">
                        </td>
                        <td>
                          <button type="button" class="btn btn btn-warning" data-toggle="modal" data-target="#edit<?= $row["id_kamar"];?>">Edit</button>
                          <a href="kamar.php?id_kamar=<?php echo $row['id_kamar']; ?>" class="btn btn btn-danger" onclick="return confirm('Anda yakin akan menghapus data ini...?')">Hapus</a>
                        </td>
                      </tr>
                      <?php $no++; } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->        

   

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->

      

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>

    <!-- Modal Tambah data kamar -->
    <div class="modal fade" id="tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Kamar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                <label>No. Kamar</label>
                <input type="text" class="form-control" name="nama_kamar" placeholder="Nomor Kamar" required>
              </div>
              <div class="form-group">
                <label>Foto Kamar</label>
                <input type="file" name="gambar" class="form-control">
              </div>         
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

<!-- Modal Edit data Kamar -->
<?php
$kamar = mysqli_query($koneksi, "SELECT * FROM kamar");
while($kmr = mysqli_fetch_assoc($kamar)): 
?>
    <div class="modal fade" id="edit<?= $kmr["id_kamar"]?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Kamar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="" enctype="multipart/form-data">
              <input type="text" name="id_kamar" value="<?= $kmr["id_kamar"] ?>" hidden>
              <input type="text" name="gambarLama" value="<?= $kmr["gambar"] ?>" hidden>
              <div class="form-group">
                <label>Nama Kamar</label>
                <input value="<?= $kmr["nama_kamar"] ?>" type="text" class="form-control" name="nama_kamar" placeholder="Nama Kamar" required>
              </div>
              <div class="form-group">
                <img src="gambar/<?= $kmr["gambar"] ?>" alt="" width="100"><br>
                <label>Foto Kamar</label>
                <input type="file" name="gambar" class="form-control">
              </div>         
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="edit" class="btn btn-primary">Edit</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <?php endwhile; ?>
  </body>
  </html>