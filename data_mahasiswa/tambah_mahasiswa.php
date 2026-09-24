<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
   $nim = trim(mysqli_real_escape_string($con, $_POST['nim']));
   $nama = trim(mysqli_real_escape_string($con, $_POST['nama']));
   $kontak = trim(mysqli_real_escape_string($con, $_POST['kontak']));
   $surel = trim(mysqli_real_escape_string($con, $_POST['email']));
   $kelamin = trim(mysqli_real_escape_string($con, $_POST['kelamin']));
  

   $cek_user =  mysqli_query($con, "SELECT nim FROM tbl_mahasiswa WHERE nim='$nim'")
   or die(mysqli_error($con));

   $rv = mysqli_num_rows($cek_user);

   if ($rv == 1) {
     echo '
     <script> alert ("NIM Sudah Terdaftar!!! Input yang lain")
     window.location.href = "../data_mahasiswa/"
     </script>
     ';
   } else {
     $query_simpan = mysqli_query($con, "INSERT INTO tbl_mahasiswa 
     (nim, 
      nama, 
      kontak, 
      email, 
      kelamin) 
     VALUES (
     '$nim',
     '$nama',
     '$kontak',
     '$surel',
     '$kelamin'
     )") or die(mysqli_error($con));



    $cek_user = mysqli_query($con, "SELECT username FROM tbl_user WHERE username='$nim'") or die(mysqli_error($con));

        if (mysqli_num_rows($cek_user) == 0) {
            $password_default = sha1($nim);
            $pin_default      = '1234';

            mysqli_query($con, "INSERT INTO tbl_user (
            username,
            sandi,
            peran,
            pin,
            nama)
            VALUES (
            '$nim',
            '$password_default',
            'M',
            '$pin_default',
            '$nama'
            )") or die(mysqli_error($con));
        }

        echo '
        <script>
         alert("Data Berhasil Disimpan & Akun Pengguna Otomatis Dibuat");
         window.location.href = "../data_mahasiswa/"
        </script>';
    }
}
?>