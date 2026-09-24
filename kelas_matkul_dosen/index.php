<?php
require_once '../database/koneksi.php';
$authority = $_SESSION['peran'];
if ($authority != 'D') {
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

  require_once '../database/koneksi.php';
  $hal = 'kelas_dosen';
  
  ?>
</head>

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
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php include '../sidebar_dosen.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content pt-3">
      <div class="container-fluid">
        <form action="" method="post">
          <div class="row">
            <div class="col-3">
              <?php 
              $panggil_periode_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik");
              ?>
              <div class="form-group">                    
                <select class="form-control" name="semester">
                  <option value="">-- Pilih Periode--</option>
                  <?php 
                  if ($panggil_periode_akademik && mysqli_num_rows($panggil_periode_akademik) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_periode_akademik)) {
                          $kode_akd = $data_periode['kode_akd'];
                          $semester = $data_periode['semester'];
                          $tahun = $data_periode['tahun'];
                      ?>
                        <option value="<?= $kode_akd; ?>"><?= $tahun ?> - <?= ($semester == 'GL') ? 'Ganjil' : 'Genap' ?></option>
                      <?php 
                      }
                  } else {
                      echo '<option value="">Pilih Periode Akademik</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-6">
              <button type="submit" name="btn_cari" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
            </div>
          </div>
        </form>

        <?php if (isset($_POST['btn_cari'])) { 
          $filter = trim(mysqli_real_escape_string($con, $_POST['semester']));
          $nik_dosen = $_SESSION['nik'];
          ?>
        <div class="row mt-2">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Kelas Mata Kuliah</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kode Akademik</th>
                    <th>Kode Matkul</th>
                    <th>Kode Jurusan</th>
                    <th>Nik</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_akd = '$filter' AND nik = '$nik_dosen'") or die(mysqli_error($con));                    
                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_kelas); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_kelas)) {
                        $kode_kelas = $data['kode_kelas'];
                        $kode_akd = $data['kode_akd'];
                        $kode_matkul = $data['kode_matkul'];
                        $kode_jurusan = $data['kode_jurusan'];
                        $nik = $data['nik'];
                        $nama_kelas = $data['nama_kelas'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td>
                            <?php 
                            $query_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik WHERE kode_akd = '$kode_akd'")or die(mysqli_error($con));
                            $data_akademik = mysqli_fetch_array($query_akademik);
                            echo $data_akademik['tahun'].'-'.($data_akademik['semester']=='GN'?'Genap':'Ganjil');
                            ?>
                          </td>
                          <td>
                            <?php 
                            $query_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'")or die(mysqli_error($con));
                            $data_matkul = mysqli_fetch_array($query_matkul);
                            echo $data_matkul['kode_matkul'].'-'.$data_matkul['nama_matkul'];
                            ?>
                          </td>
                          <td>
                            <?php 
                            $query_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'")or die(mysqli_error($con));
                            $data_jurusan = mysqli_fetch_array($query_jurusan);
                            echo $data_jurusan['kode_jurusan'].'-'.$data_jurusan['nama_jurusan'];
                            ?>
                          </td>
                          <td>
                            <?php 
                            $query_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen WHERE nik = '$nik'")or die(mysqli_error($con));
                            $data_dosen = mysqli_fetch_array($query_dosen);
                            echo $data_dosen['nik'].'-'.$data_dosen['nama'];
                            ?>
                          </td>
                          <td><?= $nama_kelas; ?></td>
                          

                          <td>
                            <a href='hapus.php?user=<?= $data['kode_kelas'];?>' class="btn btn-danger btn-xs" onclick="return confirm('yakeeeen?')">
                              <i class="fas fa-trash"></i></a>

                           <button type="button" class="btn btn-primary btn-xs" 
                            data-toggle="modal" data-target="#modal-edit"
                            data-kelas="<?= $kode_kelas; ?>"
                            data-kode_akd="<?= $kode_akd; ?>"
                            data-kode_matkul="<?= $kode_matkul; ?>"
                            data-kode_jurusan="<?= $kode_jurusan; ?>"
                            data-nik="<?= $nik; ?>"
                            data-nama_kelas="<?= $nama_kelas; ?>"
                            ><i class="fas fa-edit"></i>
                          </button>

                          <a href='detail_kelas_matkul.php?user=<?= $kode_kelas?>' class="btn btn-danger btn-xs">
                              <i class="fas fa-eye"></i></a>
                          
                          <a href='pertemuan.php?id=<?= $data['kode_kelas'];?>' class="btn btn-warning btn-xs">
                              <i class="fas fa-qrcode"></i></a>

                          
                          
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
        <?php } ?>

      </div>
    </div>
  </div>
  

  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- MODAL TAMBAH DATA -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Kelas Matkul</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah_kelas.php" method="post">
          <div class="modal-body">

            
            <?php 
              $panggil_periode_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik");
              ?>
              <div class="form-group">   
                <label for="kode_matkul">Periode Akademik</label>                 
                <select class="form-control" name="kode_akd">
                  <option value="">Pilih Periode Akademik</option>
                  <?php 
                  if ($panggil_periode_akademik && mysqli_num_rows($panggil_periode_akademik) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_periode_akademik)) {
                          $kode_akd = $data_periode['kode_akd'];
                          $semester = $data_periode['semester'];
                          $tahun = $data_periode['tahun'];
                      ?>
                        <option value="<?= $kode_akd; ?>"><?= $tahun ?> - <?= ($semester == 'GL') ? 'Ganjil' : 'Genap' ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul");
              ?>
              <div class="form-group">   
                <label for="kode_matkul">Mata Kuliah</label>                 
                <select class="form-control" name="kode_matkul">
                  <option value="">Pilih Mata Kuliah</option>
                  <?php 
                  if ($panggil_matkul && mysqli_num_rows($panggil_matkul) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_matkul)) {
                          $kode_matkul = $data_periode['kode_matkul'];
                          $nama_matkul = $data_periode['nama_matkul'];
                      ?>
                        <option value="<?= $kode_matkul; ?>"><?= $nama_matkul ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan");
              ?>
              <div class="form-group">   
                <label for="kode_jurusan">Jurusan</label>                 
                <select class="form-control" name="kode_jurusan">
                  <option value="">Pilih Jurusan</option>
                  <?php 
                  if ($panggil_jurusan && mysqli_num_rows($panggil_jurusan) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_jurusan)) {
                          $kode_jurusan = $data_periode['kode_jurusan'];
                          $nama_jurusan = $data_periode['nama_jurusan'];
                      ?>
                        <option value="<?= $kode_jurusan; ?>"><?= $nama_jurusan ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen");
              ?>
              <div class="form-group">   
                <label for="kode_dosen">Nama Dosen</label>                 
                <select class="form-control" name="nik">
                  <option value="">Pilih Dosen</option>
                  <?php 
                  if ($panggil_dosen && mysqli_num_rows($panggil_dosen) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_dosen)) {
                          $nik = $data_periode['nik'];
                          $nama_dosen = $data_periode['nama'];
                      ?>
                        <option value="<?= $nik; ?>"><?= $nik ?> - <?= $nama_dosen ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>


            <div class="form-group">
              <label for="nama_kelas">Nama Kelas</label>
              <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" placeholder="Masukan Nama Kelas" required>
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


  <!-- MODAL EDIT -->
  <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Kelas Kuliah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="ubah.php" method="post">
            <div class="modal-body">

              <?php 
              $panggil_periode_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik");
              ?>
              <div class="form-group">   
                <input type="text" name="kode_kelas" required hidden>
                <label for="kode_akd">Periode Akademik</label>                 
                <select class="form-control" name="kode_akd">
                  <option value="">Pilih Periode Akademik</option>
                  <?php 
                  if ($panggil_periode_akademik && mysqli_num_rows($panggil_periode_akademik) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_periode_akademik)) {
                          $kode_akd = $data_periode['kode_akd'];
                          $semester = $data_periode['semester'];
                          $tahun = $data_periode['tahun'];
                      ?>
                        <option value="<?= $kode_akd; ?>"><?= $tahun ?> - <?= ($semester == 'GL') ? 'Ganjil' : 'Genap' ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul");
              ?>
              <div class="form-group">   
                <label for="kode_matkul">Mata Kuliah</label>                 
                <select class="form-control" name="kode_matkul">
                  <option value="">Pilih Mata Kuliah</option>
                  <?php 
                  if ($panggil_matkul && mysqli_num_rows($panggil_matkul) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_matkul)) {
                          $kode_matkul = $data_periode['kode_matkul'];
                          $nama_matkul = $data_periode['nama_matkul'];
                      ?>
                        <option value="<?= $kode_matkul; ?>"><?= $nama_matkul ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan");
              ?>
              <div class="form-group">   
                <label for="kode_jurusan">Jurusan</label>                 
                <select class="form-control" name="kode_jurusan">
                  <option value="">Pilih Jurusan</option>
                  <?php 
                  if ($panggil_jurusan && mysqli_num_rows($panggil_jurusan) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_jurusan)) {
                          $kode_jurusan = $data_periode['kode_jurusan'];
                          $nama_jurusan = $data_periode['nama_jurusan'];
                      ?>
                        <option value="<?= $kode_jurusan; ?>"><?= $nama_jurusan ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <?php 
              $panggil_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen");
              ?>
              <div class="form-group">   
                <label for="kode_dosen">Nama Dosen</label>                 
                <select class="form-control" name="nik">
                  <option value="">Pilih Dosen</option>
                  <?php 
                  if ($panggil_dosen && mysqli_num_rows($panggil_dosen) > 0) {
                      while ($data_periode = mysqli_fetch_array($panggil_dosen)) {
                          $nik = $data_periode['nik'];
                          $nama_dosen = $data_periode['nama'];
                      ?>
                        <option value="<?= $nik; ?>"><?= $nik ?> - <?= $nama_dosen ?></option>
                      <?php 
                      }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" placeholder="Masukkan Email"  required>
              </div>

              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="btn_edit" class="btn btn-primary">Edit</button>
            </div>
          </form>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- MODAL IMPOR -->
    <div class="modal fade" id="modal-impor">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Impor Data Kelas</h4>
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
                <label for="file">Download Template</label> <br>
              <a href="template/template_data_kelas.xls" class="btn btn-success" download>Download</a>
              </div>

              <div class="row">
                <div class="col-6">
                   <label for="file">Mahasiswa</label> <br>
                    <a href="../data_mahasiswa/excel.php" class="btn btn-success" download>Download</a>
                </div>
                <div class="col-6">
                   <label for="file">Matkul</label> <br>
                   <a href="../data_matakuliah/excel.php" class="btn btn-success" download>Download</a>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                   <label for="file">Jurusan</label> <br>
                   <a href="../data_jurusan/excel.php" class="btn btn-success" download>Download</a>
                </div>
                <div class="col-6">
                   <label for="file">Dosen</label> <br>
                   <a href="../data_dosen/excel.php" class="btn btn-success" download>Download</a>
                </div>
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

  <!-- Main Footer -->
  <?php include '../footer.php'; ?>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>


<script>
  $('#modal-edit').on('show.bs.modal', function (e) {
    var kelas = $(e.relatedTarget).data('kelas');
    var kode_akd = $(e.relatedTarget).data('kode_akd');
    var matkul = $(e.relatedTarget).data('kode_matkul');
    var jurusan = $(e.relatedTarget).data('kode_jurusan');
    var nik = $(e.relatedTarget).data('nik');
    var nama = $(e.relatedTarget).data('nama_kelas');


    $(e.currentTarget).find('input[name="kode_kelas"]').val(kelas);
    $(e.currentTarget).find('select[name="kode_akd"]').val(kode_akd);
    $(e.currentTarget).find('select[name="kode_matkul"]').val(matkul);
    $(e.currentTarget).find('select[name="kode_jurusan"]').val(jurusan);
    $(e.currentTarget).find('select[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama_kelas"]').val(nama);
  });
</script>

</body>
</html>
<?php } ?>