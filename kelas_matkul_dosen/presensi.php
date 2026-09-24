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

  
  $hal = 'kelas_matkul';
  
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
 include'../sidebar_dosen.php';
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
                <?php
                  $id_pertemuan = @$_GET['id'];
                  $panggil_data_pertemuan = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE id='$id_pertemuan'")or die(mysqli_error($con));
                  $data_pertemuan = mysqli_fetch_array($panggil_data_pertemuan);

                  $kode_kls = $data_pertemuan['kode_kelas'];
                  $tanggal_pertemuan = $data_pertemuan['tanggal'];
                  $judul_pertemuan = $data_pertemuan['judul_pertemuan'];
                  $pertemuan_ke = $data_pertemuan['pertemuan_ke'];
                  $status_pertemuan = $data_pertemuan['status'];

                  $panggil_data_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_kelas = '$kode_kls'")or die(mysqli_error($con));
                  $data_kelas = mysqli_fetch_array($panggil_data_kelas);

                  $nik = $data_kelas['nik'];
                  $panggila_data_dosen = mysqli_query($con, "SELECT nama,img,kelamin FROM tbl_dosen WHERE nik='$nik'")or die(mysqli_error($con));
                  $data_dosen = mysqli_fetch_array($panggila_data_dosen);
                  $foto = $data_dosen['img'];
                  $jk = $data_dosen['kelamin'];

                  $kode_matkul = $data_kelas['kode_matkul'];
                  $panggil_data_matkul = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'")or die(mysqli_error($con));
                  $data_matkul = mysqli_fetch_array($panggil_data_matkul);

                  $kode_jurusan = $data_kelas['kode_jurusan'];
                  $panggil_data_jurusan = mysqli_query($con, "SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan='$kode_jurusan'")or die(mysqli_error($con));
                  $data_jurusan = mysqli_fetch_array($panggil_data_jurusan);
                ?>
                <h3 class="card-title">KELAS MATA KULIAH <?= $kode_kls; ?></h3>
              </div>
              
              <!-- Card Body berisi satu baris (row) dengan 3 kolom di dalamnya -->
              <div class="card-body">
                <div class="row"> 
                
                  <div class="col-lg-3 border-right">
                    <div class="mb-3 text-center">
                      <?php 
                      if ($jk == 'L') {
                      ?>
                        <img src="<?= $foto!=null ? $foto : '../asset_web/image/mhs_lakilaki.png' ?>" alt="foto dosen" class="img-fluid" style="width: 500px;" >
                      <?php
                      } else {
                      ?>
                      <img src="<?= $foto!=null ? $foto : '../asset_web/image/mhs_perempuan.png' ?>" alt="foto dosen" class="img-fluid" style="width: 500px;" >
                      <?php
                      
                      }
                      ?>
                    </div>
                    <?php 
                    if ($status_pertemuan == 1) {
                      ?>
                      <a href="buka.php?id=<?= $id_pertemuan ?>" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Apakah anda yakin ingin menutup presensi ini?')">
                      <i></i> Tutup Presensi</a>
                      <?php

                    } else {
                      ?>
                      <a href="buka.php?id=<?= $id_pertemuan ?>" class="btn btn-success btn-sm btn-block" onclick="return confirm('Apakah anda yakin ingin membuka presensi ini?')">
                      <i></i> Buka Presensi</a>
                      <?php

                    }
                    ?>
                    
                  </div>
                  
                  
                  <div class="col-lg-5 border-right">
                        <table class="table table-sm" >
                            <tr>
                                <th style="width: 30%;">NIK</th>
                                <td>: <?= $nik; ?></td>
                            </tr>
                            <tr>
                                <th>Nama Dosen</th>
                                <td>: <?= $data_dosen['nama']; ?></td>
                            </tr>
                            <tr>
                                <th>Mata Kuliah</th>
                                <td>: <?= $data_matkul['nama_matkul']; ?></td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>: <?= $judul_pertemuan; ?></td>
                            </tr>
                            <tr>
                                <th>Kelas </th>
                                <td>: <?= $data_kelas['nama_kelas']; ?></td>
                            </tr>

                            <tr>
                                <th>Jurusan </th>
                                <td>: <?= $data_jurusan['nama_jurusan']; ?></td>
                            </tr>
                            <tr>
                                <th>Hari </th>
                                <td>: <?= date('l', strtotime($tanggal_pertemuan)); ?></td>
                            </tr>

                            <tr>
                                <th>Tanggal </th>
                                <td>: <?= date('d F Y') ?></td>
                            </tr>

                            <tr>
                                <th>Pertemuan Ke </th>
                                <td>: <?= $pertemuan_ke; ?></td>
                            </tr>

                        </table>
                  </div>
                  
                 
                  <div class="col-lg-4">
                    <div class="text-center">
                      <?php

                        include('../asset_web/phpqrcode/qrlib.php');
                        // include('config.php');
                        
                        $isi_qr = $kode_kls;
                        
                        $fileName = 'QR-presensi-'.$kode_kls.'-'.round(microtime(true)).'.png';
                        $alamat_tujuan = 'qr/';
                        $alamat_qr = $alamat_tujuan.$fileName;
                        
                        // generating
                        
                            QRcode::png($isi_qr, $alamat_qr);
                        
                        // displaying
                        
                      ?>
                      <img src="<?= $alamat_qr; ?>" alt="qr presensi" class="img-fluid mb-2" style="width: 250px;">
                      <div>
                        <p>Scan QR untuk melakukan presensi</p>
                        <p id="demo" class="text-danger"></p>
                      </div>

                      
                    </div>
                  </div>
                   
                </div> 
                <div class="row mt-4">
                  <div class="col-lg-12">
                    <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_presensi = mysqli_query($con, "SELECT * FROM tbl_presensi WHERE id_pertemuan = '$id_pertemuan'") or die(mysqli_error($con));

                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_presensi); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_presensi)) {
                        $id_presensi = $data['id'];
                        $nim = $data['nim'];
                        $status_kehadiran = $data['status_kehadiran'];
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
                          <?php 
                          $warna = 'danger';
                          if ($status_kehadiran == 'hadir') {
                            $warna = 'success';
                          } elseif ($status_kehadiran == 'izin') {
                            $warna = 'warning';
                          } elseif ($status_kehadiran == 'sakit') {
                            $warna = 'primary';
                          } else{
                            $warna = 'danger';
                          }
                          ?>  
                          <span class="badge badge-<?= $warna ?>"><?= $status_kehadiran; ?></span>
                          </td>

                          <td>
                            <button type="button" class="btn btn-primary btn-xs" 
                            data-toggle="modal" data-target="#modal-edit"
                            data-presensi="<?= $id_presensi; ?>"
                            data-id="<?= $id_pertemuan; ?>"
                            ><i class="fas fa-edit"></i>
                          </button>
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
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- MODAL EDIT -->
  <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data presensi</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="ubah_status.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" name="presensi" hidden>
                <input type="text" name="id_pertemuan" hidden>
   
                <label for="status_kehadiran">Status</label>                 
                <select class="form-control" name="status_kehadiran">
                  <option value="">-- Pilih Status Kehadiran--</option>
                  <option value="hadir">Hadir</option>
                  <option value="alpha">Alpha</option>
                  <option value="izin">Izin</option>
                  <option value="sakit">Sakit</option>
                </select>
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

<?php 
if ($status_pertemuan == 1) { 
?>

<script>
// Set the date we're counting down to
var countDownDate = new Date().getTime() + (1 * 60 * 1000);

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = minutes + "m" + seconds + "s";
    
   if (distance < 0) {
      clearInterval(x);
       window.location.href = "buka.php?id=<?= $id_pertemuan ?>";
    }
  }, 1000);
</script>
<?php
}
?>

<script>
  $('#modal-edit').on('show.bs.modal', function (e) {
    var presensi = $(e.relatedTarget).data('presensi');
    var hadir = $(e.relatedTarget).data('id');


    
    $(e.currentTarget).find('input[name="presensi"]').val(presensi);
    $(e.currentTarget).find('input[name="id_pertemuan"]').val(hadir);
  });
</script>

</body>
</html>
<?php
}
?>