<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
   $nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
   $nama = trim(mysqli_real_escape_string($con, $_POST['nama']));
   $kontak = trim(mysqli_real_escape_string($con, $_POST['kontak']));
   $surel = trim(mysqli_real_escape_string($con, $_POST['email']));
   $kelamin = trim(mysqli_real_escape_string($con, $_POST['kelamin']));
   $image = trim(mysqli_real_escape_string($con, $_POST['img']));
  

   $cek_user =  mysqli_query($con, "SELECT nik FROM tbl_dosen WHERE nik='$nik'")
   or die(mysqli_error($con));

   $rv = mysqli_num_rows($cek_user);

   if ($rv == 1) {
     echo '
     <script> alert ("NIK Sudah Terdaftar!!! Input yang lain")
     window.location.href = "../data_dosen/"
     </script>
     ';
   } else {
     $query_simpan = mysqli_query($con, "INSERT INTO tbl_dosen 
     (nik, 
      nama, 
      kontak, 
      email, 
      kelamin,
      img) 
     VALUES (
     '$nik',
     '$nama',
     '$kontak',
     '$surel',
     '$kelamin',
     '$img'
     )") or die(mysqli_error($con));



    $cek_user = mysqli_query($con, "SELECT username FROM tbl_user WHERE username='$nik'") or die(mysqli_error($con));

        if (mysqli_num_rows($cek_user) == 0) {
            $password_default = sha1($nik);
            $pin_default      = '1234';

            mysqli_query($con, "INSERT INTO tbl_user (
            username,
            sandi,
            peran,
            pin,
            nama)
            VALUES (
            '$nik',
            '$password_default',
            'D',
            '$pin_default',
            '$nama'
            )") or die(mysqli_error($con));
        }

        echo '
        <script>
         alert("Data Berhasil Disimpan & Akun Pengguna Otomatis Dibuat");
         window.location.href = "../data_dosen/"
        </script>';
    }
}
?>