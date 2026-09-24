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

 $hal = 'admin_akademik'; 
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
 include'../sidebar_admin.php';
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
                <h3 class="card-title">Akademik</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-default" ><i class="fas fa-plus" ></i> Tambah Data</button>
                <a href="excel.php" type="button" target="_blank" class="btn bg-pink mb-2">
                  <i class="fas fa-file-excel"></i> Export Data Excel</a>
                <div class="container-fluid">
                  <!-- <?php
                  // $pengguna = $_SESSION['nim'];
                  ?> -->
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode Akademik</th>
                    <th>Semester</th>
                    <th>Tahun</th>
                    <th>Is active</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik")or die(mysqli_error());
                    
                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_akademik); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_akademik)) {
                        $kode_akd = $data['kode_akd'];
                        $semester = $data['semester'];
                        $tahun = $data['tahun'];
                        $is_active = $data['is_active'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $kode_akd; ?></td>
                          <td>
                            <?php
                            $semester = $data['semester'];
                            if ($semester == 'GL') {
                              echo 'Ganjil';
                            } else {
                              echo 'Genap';
                            };
                            ?>
                          </td>
                          <td><?= $tahun; ?></td>
                          <td>
                            <?php
                            $is_active = $data['is_active'];
                            if ($is_active == '0') {
                              echo 'Tidak Aktif';
                            } else {
                              echo 'Aktif';
                            };
                            ?>
                          </td>


                          
                           <td>
                            <a href='hapus.php?user=<?= $data['nim'];?>' class="btn btn-danger btn-xs" onclick="return confirm('yakeeeen?')">
                              <i class="fas fa-trash"></i></a>
                            <a href='edit.php?user=<?= $data['nim'];?>' class="btn btn-success btn-xs">
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
              <h4 class="modal-title">Tambah Data Akademik</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="tambah_akademik.php" method="post">
                <div class="modal-body">
                      <div class="form-group">
                        <label for="kode_akd">Kode Akademik</label>
                        <input type="text" name="kode_akd" class="form-control" id="kode_akd" placeholder="Masukan Kode Akademik" required>
                      </div>

                      <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="text" name="semester" class="form-control"  id="semester" placeholder="Masukan Semester" required>
                      </div>

                      <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" name="tahun" class="form-control"  id="tahun" placeholder="Masukan Tahun" required>
                      </div>

                      <div class="form-group">
                        <label for="is_active">Status</label>
                        <input type="text" name="is_active" class="form-control"  id="is_active" placeholder="Masukan Status" required>
                      </div>
                   
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" name="btn_tambah" class="btn btn-primary">Tambah</button>
                </div>

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
