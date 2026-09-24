<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
   $kode_kelas = trim(mysqli_real_escape_string($con, $_POST['kode_kelas']));
   $nim = trim(mysqli_real_escape_string($con, $_POST['nim']));

   $cek_user =  mysqli_query($con, "SELECT kode_kelas FROM tbl_detail_kelas WHERE kode_kelas='$kode_kelas'
   AND nim = '$nim'")
   or die(mysqli_error($con));

   $rv = mysqli_num_rows($cek_user);

   if ($rv > 0) {
     echo '
     <script> alert ("Mahasiswa tersebut sudah terdaftar di kelas ini!!! Input yang lain");
     window.location.href = "detail_kelas_matkul.php?user=' . $kode_kelas . '";
     </script>
     ';
   } else {
     $query_simpan = mysqli_query($con, "INSERT INTO tbl_detail_kelas 
     (
      kode_kelas, 
      nim) 
     VALUES (
     '$kode_kelas',
     '$nim'
     )") or die(mysqli_error($con));

        echo '
        <script>
         alert("Data Mahasiswa Berhasil Ditambahkan");
         window.location.href = "detail_kelas_matkul.php?user=' . $kode_kelas . '";
        </script>';
    }
}
?>