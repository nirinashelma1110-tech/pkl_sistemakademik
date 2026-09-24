<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if($authority !='A'){
  echo '<script>
  alert ("Akan Segera Di Logout Dari akun Admin bye") </script>';
  
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
 
 
 $hal = 'admin_matkul';
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
          <?= $_SESSION['nama']; ?> - [<?= $_SESSION['peran'];?>]
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </a>

        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen PKL</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      
      <!-- /.sidebar-menu -->
       <?php
       include '../sidebar_admin.php';
       ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data 2</h3>
                </div>
                <div class="card-body">
                    <form  action="" method="post">
                            <div class="form-group">
                                <label for="kode_matkul">Kode Makul</label>
                               
                               
                                <input type="text" name="kode_matkul" class="form-control"
                                placeholder="Masukan Kode Makul" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_matkul">Nama Makul</label>
                                <input type="text" name="nama_matkul" class="form-control"
                                placeholder="Masukan Nama Makul" required>
                            </div>
                                <div class="form-group">
                                <label for="jml_sks">Jumlah SKS </label>
                                <input type="number" name="jml_sks" class="form-control"
                                placeholder="Masukan Jumlah SKS" required>
                             </div>
                                <div class="form-group">
                                <label for="jml_cpmk">Jumlah CPMK </label>
                                <input type="number" name="jml_cpmk" class="form-control"
                                placeholder="Masukan Jumlah CPMK" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="btn_tambah" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Tambah Data Makul</button>
                            </div>
                        </form>

                        <?php


if (isset($_POST['btn_tambah'])){
    $kode_matkul = trim(mysqli_real_escape_string($con, $_POST['kode_matkul']));
    $nama_matkul = trim(mysqli_real_escape_string($con, $_POST['nama_matkul']));
    $jml_sks = trim(mysqli_real_escape_string($con, $_POST['jml_sks']));
    $jml_cpmk = trim(mysqli_real_escape_string($con, $_POST['jml_cpmk']));


    $cek_matkul = mysqli_query($con, "SELECT kode_matkul FROM tb_matkul WHERE kode_matkul = '$kode_matkul'") or die (mysqli_error($con));
    $rv = mysqli_num_rows($cek_matkul);

    if ($rv == 1){
        echo '
        <script>
            alert("Kode Makul Sudah Terdaftar");
            window.location.href="../data_matkul"
        </script>';
    } else {
        $query_simpan = mysqli_query($con, "INSERT INTO tb_matkul (
            kode_matkul, nama_matkul, jml_sks, jml_cmpk
        ) VALUES (
            '$kode_matkul','$nama_matkul','$jml_sks','$jml_cpmk'
        )") or die(mysqli_error($con));

        
        echo '
        <script> 
            alert("Data Makul berhasil disimpan");
            window.location.href="../data_matkul"    
        </script>';
    }
}

?>
                </div>
            </div>
    </div>
      <!-- <p> ini halaman Matakuliah </p> -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
        <!-- /.row -->
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