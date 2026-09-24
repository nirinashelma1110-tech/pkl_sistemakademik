<?php
require_once '../database/koneksi.php';
$authority = $_SESSION['peran'];
if ($authority != 'A') {
  echo '<script>
  alert ("Akun ini melakukan cross authority. Akan segera logout");</script>';
  echo '<script> 
  window.location.href = "../logout.php"
  </script>' ;
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';

  
  $hal = 'detail_kelas_matkul';
  
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
          <?= $_SESSION['nama']; ?> <?= $_SESSION['peran']; ?> <i class="far fa-user"></i>

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
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="header"> Detail Kelas Matkul</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $kode_kelas = @$_GET['user'];

                        $query_ambil_data = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($con));
                        $data = mysqli_fetch_array($query_ambil_data);
                        if(!$data){
                            echo '<script>
                                alert("Data Kelas tidak ditemukan!");
                                window.location.href="../kelas_matakuliah";
                                exit;
                            </script>';
                        }

                        $kode_kelas = $data['kode_kelas'];  
                        $kode_akd = $data['kode_akd'];
                        $kode_matkul = $data['kode_matkul'];
                        $kode_jurusan= $data['kode_jurusan'];
                        $nik = $data['nik'];
                        $nama_kelas = $data['nama_kelas'];
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Periode Akademik</th>
                                        <td>:  <?php 
                                    $query_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik WHERE kode_akd = '$kode_akd'")or die(mysqli_error($con));
                                    $data_akademik = mysqli_fetch_array($query_akademik);
                                    echo $data_akademik['tahun'].'-'.($data_akademik['semester']=='GN'?'Genap':'Ganjil');
                                    ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <td>:  <?php 
                                    $query_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'")or die(mysqli_error($con));
                                    $data_matkul = mysqli_fetch_array($query_matkul);
                                    echo $data_matkul['kode_matkul'].'-'.$data_matkul['nama_matkul'];
                                    ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>: <?php 
                                    $query_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'")or die(mysqli_error($con));
                                    $data_jurusan = mysqli_fetch_array($query_jurusan);
                                    echo $data_jurusan['kode_jurusan'].'-'.$data_jurusan['nama_jurusan'];
                                    ?></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Dosen</th>
                                        <td>: <?php 
                                    $query_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen WHERE nik = '$nik'")or die(mysqli_error($con));
                                    $data_dosen = mysqli_fetch_array($query_dosen);
                                    echo $data_dosen['nik'].'-'.$data_dosen['nama'];
                                    ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <td>: <?= $nama_kelas ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-body">
                 <button type="button" class="btn btn-primary mb-2" 
                            data-toggle="modal" data-target="#modal-default"
                            data-kelas="<?= $kode_kelas; ?>"
                            data-nim="<?= $nim; ?>"
                            ><i class="fas fa-plus"> Tambah Data</i>
                          </button>
                  <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor" ><i class="fas fa-file-excel" ></i> Impor Data</button>
                   <a href="../kelas_matakuliah/" class="btn btn-primary mb-2" ">
                  <i class="fas fa-arrow-left"></i> Kembali ke Data Kelas
                </a>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Mahasiswa</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_kelas = mysqli_query($con, "SELECT * FROM tbl_detail_kelas WHERE kode_kelas = '$kode_kelas'") or die(mysqli_error($con));
                    
                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_kelas); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_kelas)) {
                        $nim = $data['nim'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td>
                            <?php 
                            $query_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'")or die(mysqli_error($con));
                            $data_mahasiswa = mysqli_fetch_array($query_mahasiswa);
                            
                            if ($data_mahasiswa) {
                                echo $data_mahasiswa['nim'] . '-' . $data_mahasiswa['nama'];
                            } 
                            ?>
                          </td>

                          <td>
                            <a href='hapus.php?user=<?= $data['nim'];?>' class="btn btn-danger btn-xs" onclick="return confirm('yakeeeen?')">
                              <i class="fas fa-trash"></i></a>
                          </td>

                        </tr>
                        <?php  
                      }
                    } 

                    ?>
                  </tbody>
                  
                </table>
              </div>
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
  <!-- /.control-sidebar -->]


  <!-- MODAL TAMBAH DATA -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Mahasiswa di Kelas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah_detail.php" method="post">
          <div class="modal-body">

            
            <?php 
              $panggil_kelas= mysqli_query($con, "SELECT * FROM tbl_kelas_matkul");
              ?>
              <div class="form-group">   
                <label for="kode_kelas">Pilih Kelas</label>                 
                <select class="form-control" name="kode_kelas">
                  <option value="">Pilih Kelas</option>
                  <?php 
                  if ($panggil_kelas && mysqli_num_rows($panggil_kelas) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_kelas)) {
                          $kode_kelas = $data_periode['kode_kelas'];
                          $nama_kelas = $data_periode['nama_kelas'];
                      ?>
                        <option value="<?= $kode_kelas; ?>"><?= $kode_kelas ?> - <?= $nama_kelas ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mahasiswa");
              ?>
              <div class="form-group">   
                <label for="nim">Pilih Mahasiswa</label>                 
                <select class="form-control" name="nim">
                  <option value="">Pilih Matahasiswa</option>
                  <?php 
                  if ($panggil_mahasiswa && mysqli_num_rows($panggil_mahasiswa) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_mahasiswa)) {
                          $nim = $data_periode['nim'];
                          $nama = $data_periode['nama'];
                      ?>
                        <option value="<?= $nim; ?>"><?= $nim ?> - <?= $nama ?></option>
                      <?php 
                      }
                  }
                  ?>
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

  <!-- MODAL IMPOR -->
    <div class="modal fade" id="modal-impor">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Impor Data Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="impor.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="kode_kelas" value="<?= $kode_kelas; ?>">

            <div class="modal-body">
              <div class="form-group">
                <label for="file">Upload File Template</label>
                <input type="file" class="form-control" name="file_excel" required>
              </div>

              <div class="form-group">
                <label for="file">Download File Template</label> <br>
              <a href="template/template_detail_kelas.xls" class="btn btn-success" download>Download</a>
              </div>
              
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="btn_impor" class="btn btn-primary">Impor</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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

<script>
  $('#modal-default').on('show.bs.modal', function (e) {
    var kelas = $(e.relatedTarget).data('kelas');


    $(e.currentTarget).find('select[name="kode_kelas"]').val(kelas);
  });
</script>
</body>
</html>
<?php
}
?>