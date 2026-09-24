<?php
require_once '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';

  $hal ='beranda_matakuliah';
  ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
    <?php 
    include '../sidebar_admin.php' ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- /.card-header -->
     
     <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Data Matkul</h3>
          </div>
        
              <div class="card-body">
                <?php 
                // Menangkap parameter dari index.php (yang dikirim adalah kode_matkul dari parameter ?user=)
                $pengguna = @$_GET['user'];
                
                // Memanggil data matkul dari database berdasarkan kode_matkul
                $query_panggil = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul='$pengguna'") or die(mysqli_error($con));
                $data = mysqli_fetch_array($query_panggil);
                
                // Menyimpan ke variabel untuk ditampilkan di form
                $kode_matkul = $data['kode_matkul'];
                $nama_matkul = $data['nama_matkul'];
                $jml_sks = $data['jml_sks'];
                $jml_cpmk = $data['jml_cpmk'];
               
                ?>
                <form action="ubah.php" method="post">
                <div class="form-group">
                  <label for="kode_matkul">Kode Makul</label>
                  <input type="text" name="kode_matkul_disable" class="form-control" id="kode_matkul" value="<?= $kode_matkul; ?>" disabled>
                  <!-- Kode asli disembunyikan untuk dikirim ke ubah.php -->
                  <input type="hidden" name="kode_matkul" class="form-control" value="<?= $kode_matkul; ?>">
                </div>
                <div class="form-group">
                  <label for="nama_matkul">Nama Makul</label>
                  <input type="text" name="nama_matkul" class="form-control" id="nama_matkul" value="<?= $nama_matkul; ?>" required>
                </div>
                <div class="form-group">
                  <label for="jml_sks">Jumlah SKS</label>
                  <input type="number" name="jml_sks" class="form-control" id="jml_sks" value="<?= $jml_sks; ?>" required>
                </div>
                <div class="form-group">
                  <label for="jml_cmpk">Jumlah CPMK</label>
                  <input type="number" name="jml_cmpk" class="form-control" id="jml_cmpk" value="<?= $jml_cmpk; ?>" required>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
              <!-- Tombol disesuaikan dengan warna coklat khas UI Anda -->
              <button type="submit" name="btn_edit" class="btn btn-block" style="background-color: #8B4513; color: white;">Edit Data</button>
            </div>
            </form>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
      <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Pengguna</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="tambah.php" method="post">
            
            </form>
      
  <!-- Main Footer -->
    <?php include '../footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php' ?>
</body>
</html>