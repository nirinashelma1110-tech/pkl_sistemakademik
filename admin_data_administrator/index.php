<?php
require_once '../database/koneksi.php';
$authority = $_SESSION['peran'];
if ($authority != 'A') {
  echo '<script>
  alert ("Akun ini melakukan cross authority. Akan segera logout");</script>';
  echo '<script> 
  window.location.href = "../logout.php"
  </script>';
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
 include '../css.php';

 $hal = 'admin_admin'; 
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
        <a class="nav-link" data-t oggle="dropdown" href="#">
          <?= $_SESSION['nama']; ?> <?= $_SESSION['peran']; ?>
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
          <div class="dropdown-divider"></div>
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
 include '../sidebar_admin.php';
?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pengguna</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus"></i> Tambah Data</button>
                <?php
                $pengguna = $_SESSION['username'];
                ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Username</th>
                    <th>Nama Pengguna</th>
                    <th>Peran</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_user = mysqli_query($con, "SELECT * FROM tbl_user") or die(mysqli_error($con));
                    
                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_user); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_user)) {
                        $user = $data['username'];
                        $nama = $data['nama'];
                        $peran = $data['peran'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $user; ?></td>
                          <td><?= $nama; ?></td>
                          <td>
                            <?php
                            $peran = $data['peran'];
                            if ($peran == 'M') {
                              echo 'Mahasiswa';
                            } elseif ($peran == 'D') {
                              echo 'Dosen';
                            } else {
                              echo 'Admin';
                            };
                            ?>
                          </td>
                          <td>
                            <a href='hapus.php?user=<?= $data['username'];?>' class="btn btn-danger btn-xs" onclick="return confirm('yakeeeen?')">
                              <i class="fas fa-trash"></i></a>
                            <a href='edit.php?user=<?= $data['username'];?>' class="btn btn-success btn-xs">
                              <i class="fas fa-pen"></i></a>
                          </td>
                        </tr>
                        <?php 
                        
                      }
                    } 

                    ?>
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
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

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pengguna</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control" id="username" placeholder="Masukan Username" required>
            </div>

            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
            </div>

            <div class="form-group">
              <label>Peran</label>
              <select class="form-control" name="peran">
                <option value="">-- Pilih Peran --</option>
                <option value="A">Admin</option>
                <option value="D">Dosen</option>
                <option value="M">Mahasiswa</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="btn_tambah" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Main Footer -->
<?php 
 include '../footer.php';
?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php 
 include '../script.php';
?>
</body>
</html>
<?php
}
?>