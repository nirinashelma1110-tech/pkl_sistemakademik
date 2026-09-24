<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
   $kode_kelas = trim(mysqli_real_escape_string($con, $_POST['kode_kelas']));
   $judul = trim(mysqli_real_escape_string($con, $_POST['judul_pertemuan']));
   $tanggal = trim(mysqli_real_escape_string($con, $_POST['tanggal']));
   

   $tanggal_sekarang = Date('Y-m-d');
    if ($tanggal < $tanggal_sekarang) {
      echo '
          <script>
          alert("Tanggal Pertemuan Minimal Hari ini");
          window.location.href = "../kelas_matakuliah/pertemuan.php?id='.$kode_kelas.'"
          </script>';
    } 

    $pertemuan_ke = 1;
    $panggil_pertemuan = mysqli_query($con, "SELECT max(pertemuan_ke) as pertemuan FROM tbl_pertemuan WHERE kode_kelas='$kode_kelas'")or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($panggil_pertemuan);
    $pertemuan_terakhir = $data_pertemuan['pertemuan'];

    $status_pertemuan = '1';

    if ($pertemuan_terakhir < 1) {
      $simpan_pertemuan = mysqli_query($con, "INSERT INTO tbl_pertemuan VALUES (null, '$kode_kelas', '$tanggal', '$judul', '$status_pertemuan', '$pertemuan_ke')")or die(mysqli_error($con));
      $id_pertemuan = mysqli_insert_id($con);
      $query_peserta = mysqli_query($con, "SELECT nim FROM tbl_detail_kelas WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($con));
      $rv = mysqli_num_rows($query_peserta);


      if ($rv > 0) {
        $status_kehadiran = 'alpha';
        while ($data_peserta = mysqli_fetch_array($query_peserta)) {
          $nim = $data_peserta['nim'];
          $query_simpan_peserta = mysqli_query($con, "INSERT INTO tbl_presensi VALUES (null, '$id_pertemuan', '$nim', '$status_kehadiran')")or die(mysqli_error($con));
        }
      }

      echo '
          <script>
          alert("Presensi Pertemuan Ke '.$pertemuan_ke.' Berhasil Dibuat");
          window.location.href = "../kelas_matakuliah/presensi.php?id='.$id_pertemuan.'"
          </script>';
    } else {
      $pertemuan_ke = $pertemuan_terakhir +1;
      $simpan_pertemuan = mysqli_query($con, "INSERT INTO tbl_pertemuan VALUES (null, '$kode_kelas', '$tanggal', '$judul', '$status_pertemuan', '$pertemuan_ke')")or die(mysqli_error($con));
      $id_pertemuan = mysqli_insert_id($con);
      
      $query_peserta = mysqli_query($con, "SELECT nim FROM tbl_detail_kelas WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($con));
      $rv = mysqli_num_rows($query_peserta);


      if ($rv > 0) {
        $status_kehadiran = 'alpha';
        while ($data_peserta = mysqli_fetch_array($query_peserta)) {
          $nim = $data_peserta['nim'];
          $query_simpan_peserta = mysqli_query($con, "INSERT INTO tbl_presensi VALUES (null, '$id_pertemuan', '$nim', '$status_kehadiran')")or die(mysqli_error($con));
        }
      }

      echo '
          <script>
          alert("Presensi Pertemuan Ke '.$pertemuan_ke.' Berhasil Dibuat");
          window.location.href = "../kelas_matakuliah/presensi.php?id='.$id_pertemuan.'"
          </script>';
    }
   
}
?>