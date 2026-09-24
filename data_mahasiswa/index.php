<?php
require_once '../database/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
 include '../css.php';

 $hal = 'admin_mahasiswa'; 
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
                <h3 class="card-title">Data Mahasiswa</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus"></i> Tambah Data</button>
                <a href="reset.php" class="btn btn-danger mb-2" onclick="return confirm('Anda yakin ingin reset?')">
                  <i class="fas fa-trash"></i> Reset Data</a>
                  
                  <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor" ><i class="fas fa-file-excel" ></i> Impor Data</button>
                  <a href="pdf.php" type="button" target="_blank" class="btn btn-danger mb-2">
                  <i class="fas fa-file-pdf"></i> Export Data</a>
                  <a href="excel.php" type="button" target="_blank" class="btn bg-pink mb-2">
                  <i class="fas fa-file-excel"></i> Export Data Excel</a>


                <?php
                  $pengguna = $_SESSION['username'];
                ?> 
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Nim</th>
                    <th>Nama Mahasiswa</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php

                    $panggil_data_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mahasiswa") or die(mysqli_error($con));
                    
                    $no = 1;

                    $rv = mysqli_num_rows($panggil_data_mahasiswa); //tampung nilai kembali

                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_mahasiswa)) {
                        $nim = $data['nim'];
                        $nama = $data['nama'];
                        $kontak = $data['kontak'];
                        $email = $data['email'];
                        $jenis_kelamin = $data['kelamin'];
                        $image = $data['img'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $nim; ?></td>
                          <td><?= $nama; ?></td>
                          <td><?= $kontak; ?></td>
                          <td><?= $email; ?></td>
                          <td>
                            <?php
                            $jenis_kelamin = $data['kelamin'];
                            if ($jenis_kelamin == 'P') {
                              echo 'Perempuan';
                            } else {
                              echo 'Laki-laki';
                            };
                            ?>
                          </td>

                          <td>
                            <?php 
                            if ($jenis_kelamin == 'L') {
                              ?>
                              <button type="button" class="btn btn-default mb-2" 
                              data-toggle="modal" data-target="#modal-foto"
                              data-nim="<?= $nim; ?>"> 
                              <src="../asset_web/image/mhs_lakilaki.png" alt="mahasiswa" class="img-fluid"</button>
                              <img  src="<?= (!empty($image)) ?$image : '../asset_web/image/mhs.lakilaki.png' ?>" alt="mahasiswa" class="img-fluid" style="width: 100px ;"> 
                              <?php
                            } else {
                              ?>
                              <button type="button" class="btn btn-default mb-2" 
                              data-toggle="modal" data-target="#modal-foto" 
                              data-nim="<?= $nim; ?>"> 
                              <src="../asset_web/image/mhs_perempuan.png" alt="mahasiswa" class="img-fluid"
                              </button>
                              <img  src="<?= (!empty($image)) ?$image : '../asset_web/image/mhs.perempuan.png' ?>" alt="mahasiswa" class="img-fluid" style="width: 100px ;"> 
                              <?php
                            }
                            ?>
                            
                          </td>

                          <td>
                            <a href='hapus.php?user=<?= $data['nim'];?>' class="btn btn-danger btn-xs" onclick="return confirm('yakeeeen?')">
                              <i class="fas fa-trash"></i></a>
                            <a href='edit.php?user=<?= $data['nim'];?>' class="btn btn-success btn-xs">
                              <i class="fas fa-pen"></i></a>

                           <button type="button" class="btn btn-primary btn-xs" 
                            data-toggle="modal" data-target="#modal-edit"
                            data-nim="<?= $nim; ?>"
                            data-nama="<?= $nama; ?>"
                            data-kontak="<?= $kontak; ?>"
                            data-email="<?= $email; ?>"
                            data-kelamin="<?= $jenis_kelamin; ?>"
                            ><i class="fas fa-edit"></i>
                          </button>

                          <a href='profile.php?user=<?= $data['nim'];?>' class="btn btn-warning btn-xs">
                              <i class="fas fa-user"></i></a>
                          
                          
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

  <!-- MODAL TAMBAH DATA -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="tambah_mahasiswa.php" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="nim">NIM</label>
              <input type="text" name="nim" class="form-control" id="nim" placeholder="Masukan NIM" required>
            </div>

            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
            </div>

            <div class="form-group">
              <label for="kontak">Kontak</label>
              <input type="number" name="kontak" class="form-control" id="kontak" placeholder="Masukan Kontak" required>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <select class="form-control" name="kelamin">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="form-group">
              <label for="img">Foto</label>
              <input type="file" name="img" class="form-control" id="img" placeholder="Upload Foto" required>
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
            <h4 class="modal-title">Edit Data Matahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="ubah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="nim">NIM</label>
                <input type="number" name="nim" class="form-control" id="nim" placeholder="Masukkan NIM" required readonly>
              </div>

              <div class="form-group">
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Mahasiswa" required>
              </div>

              <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="number" name="kontak" class="form-control" id="kontak" placeholder="Masukkan Kontak" min="1" required>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" min="0" required>
              </div>

              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="kelamin">
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
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
        <div class="modal-body">
          <div class="form-group">
            <label for="file">Upload File Template</label>
            <input type="file" class="form-control" name="file_excel" required>
          </div>

          <div class="form-group">
            <label for="file">Download File Template</label> <br>
           <a href="template/template_data_mahasiswa.xls" class="btn btn-success" download>Download</a>
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

<!-- MODAL FOTO -->
<div class="modal fade" id="modal-foto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Foto Mahasiswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="foto.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" name="nim">
            <label for="file"> Upload Foto</label>
            <input type="file" class="form-control" name="file_foto" required>
          </div>

          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" name="btn_foto" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

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

<!-- Memunculkan data di modal edit -->
<script>
  $('#modal-edit').on('show.bs.modal', function (e) {
    var nim = $(e.relatedTarget).data('nim');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');


    $(e.currentTarget).find('input[name="nim"]').val(nim);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
  });

  $('#modal-foto').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
  });
</script>

</body>
</html>