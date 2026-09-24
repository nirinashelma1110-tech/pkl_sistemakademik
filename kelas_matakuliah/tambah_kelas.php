<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
   $kode_akd = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
   $kode_matkul = trim(mysqli_real_escape_string($con, $_POST['kode_matkul']));
   $kode_jurusan = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']));
   $nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
   $nama_kelas = trim(mysqli_real_escape_string($con, $_POST['nama_kelas']));

   $cek_user =  mysqli_query($con, "SELECT kode_kelas FROM tbl_kelas_matkul WHERE kode_kelas='$kode_kelas'
   AND kode_matkul = '$kode_matkul' 
   AND kode_jurusan = '$kode_jurusan'
   AND nik = '$nik'
   AND nama_kelas = '$nama_kelas'")
   or die(mysqli_error($con));

   $rv = mysqli_num_rows($cek_user);

   if ($rv > 0) {
     echo '
     <script> alert ("Kode Kelas Sudah Terdaftar!!! Input yang lain")
     window.location.href = "../kelas_matakuliah/"
     </script>
     ';
   } else {
     $query_simpan = mysqli_query($con, "INSERT INTO tbl_kelas_matkul 
     (
      kode_akd, 
      kode_matkul,
      kode_jurusan,
      nik,
      nama_kelas) 
     VALUES (
     
     '$kode_akd',
     '$kode_matkul',
     '$kode_jurusan',
     '$nik',
     '$nama_kelas'
     )") or die(mysqli_error($con));

        echo '
        <script>
         alert("Data Kelas Berhasil Ditambahkan");
         window.location.href = "../kelas_matakuliah/"
        </script>';
    }
}
?>