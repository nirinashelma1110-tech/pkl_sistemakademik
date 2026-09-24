<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';

  require_once '../database/koneksi.php';
  $hal = 'mahasiswa_ganti_password';
  
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
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
          <div class="dropdown-divider"></div>

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
 include'../sidebar_mahasiswa.php';
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
       <?php
       $pengguna = $_SESSION['username'];
       
       ?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card, card-primary">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-lock">Ganti Password</i>
                        </div>
                            <div class="card-body">
                
                            </div>
                    </div>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="password_lama">Password Lama</label>
                                        <?php
                                        $pengguna = $_SESSION['username'];
                                        ?>
                                        <input type="text" name="pengguna" class="form-control" placeholder="input password lama" value="<?= $pengguna; ?>" hidden>
                                        <input type="password" name="password_lama" class="form-control" placeholder="input password lama">

                                    </div>

                                    <div class="form-group">
                                        <label for="password_baru">Password Baru</label>
                                        <input type="password" name="password_baru" class="form-control" placeholder="input password baru" maxlength="10" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="pin">Pin</label>
                                        <input type="number" name="pin" class="form-control" placeholder="input pin" maxlength="6" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block" name="btn_edit"><i class="fas fa-edit"></i>Edit</button>
                                    </div>
                                </form>
                                <?php
                                
                                if (isset($_POST['btn_edit'])) { //triger button edit ketika ditekan
                                    $pengguna = trim(mysqli_escape_string($con, $_POST['pengguna']));  // menyimpan value lokal pengguna di dalam variabel $pengguna
                                    $query_pengguna = mysqli_query($con, "SELECT sandi, pin from tbl_user WHERE username='$pengguna'")or die(mysqli_error($con)); // queri untuk megambil sandi dari tabel user

                                    $arr = mysqli_fetch_assoc($query_pengguna); // menyimpan array dari querry
                                    $sandi = $arr['sandi']; // menampung value sandi pada array sandi
                                    $pin = $arr['pin']; // menampung value pin pada array pin

                                    $inputan_sandi = sha1(trim(mysqli_real_escape_string($con, $_POST['password_lama']))); // menyimpan value inputan pengguna sandi lama
                                    $inputan_sandi_baru = sha1(trim(mysqli_real_escape_string($con, $_POST['password_baru']))); // 
                                    $input_pin = trim(mysqli_real_escape_string($con, $_POST['pin']));
                                    if ($inputan_sandi == $sandi && $input_pin == $pin) { //membuat sebuah kondisi agar inputan dan pin sama dengan yang di database
                                    $query_update = mysqli_query($con, "UPDATE tbl_user SET sandi='$inputan_sandi_baru' WHERE username='$pengguna'")or die(mysqli_error($con)); // query untuk update sandi
                                     echo '<script> alert("ANDA BENAR");
                                    window.location.href = "../admin_ganti_password"
                                    </script>
                                    ';

                                } else {
                                    echo '<script> alert("Password Lama atau Pin Salah");
                                    window.location.href = "../admin_ganti_password"
                                    </script>
                                    ';
                                }
                               
                                    } 
                                ?>

                </div>
            </div>
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

  <!-- Main Footer -->
<?php 
 include'../footer.php';
?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php 
 include'../script.php';
?>
</body>
</html>