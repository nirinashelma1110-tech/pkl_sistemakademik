<?php
require_once 'database/koneksi.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset_web/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="asset_web/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset_web/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="asset_web/index2.html">SISTEM MANAJEMEN XYZ</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
     

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="user" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="sandi" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mb-3">
          <button type="submit" name="login" class="btn btn-block btn-primary">
            <i class="fas fa-sign-out-alt mr-2"></i> LOGIN AKUN
          </button>
        </div>
      </form>

      <?php
      if (isset($_POST['login'])) {
         $pengguna = trim(mysqli_real_escape_string($con, $_POST['user']));

         $sandi = sha1(trim(mysqli_real_escape_string($con, $_POST['sandi'])));

         $query_cek = mysqli_query($con, "SELECT * FROM tbl_user WHERE username = '$pengguna' AND sandi='$sandi'")or die(mysqli_error($con));
        
         $rv = mysqli_num_rows($query_cek);

         if ($rv == 1) {
            $data = mysqli_fetch_assoc($query_cek);
            $peran = $data['peran'];
            $pin = $data['pin'];
            $nama = $data['nama'];
            

            $_SESSION['peran'] = $peran;
            $_SESSION['pin'] = $pin;
            $_SESSION['username'] = $pengguna;
            $_SESSION['nama'] = $nama;
            $_SESSION['nik'] = $pengguna;

            if ($peran == 'D') {
                $q_dosen = mysqli_query($con, "SELECT nik FROM tbl_dosen WHERE nik = '$pengguna' OR email = '$pengguna'");
                if ($q_dosen && mysqli_num_rows($q_dosen) > 0) {
                    $d_dosen = mysqli_fetch_assoc($q_dosen);
                    $_SESSION['nik'] = $d_dosen['nik'];
                } else {
                    $_SESSION['nik'] = $pengguna; 
                }
            }

            echo 
            '
            <script>
            window.location = "login_2fa";
            </script>
            ';
         }
      }
      ?>


      <!-- /.social-auth-links -->

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="asset_web/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="asset_web/dist/js/adminlte.min.js"></script>
</body>
</html>
