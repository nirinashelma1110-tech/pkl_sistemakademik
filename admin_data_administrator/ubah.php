<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {

    $username  = trim(mysqli_real_escape_string($con, $_POST['username']) );
    $name  = trim(mysqli_real_escape_string($con, $_POST['name']) );
    $peran  = trim(mysqli_real_escape_string($con, $_POST['peran']) );

    $query_edit = mysqli_query($con,"UPDATE tbl_user SET
    nama = '$name',
    peran = '$peran' WHERE username = '$username'
     ")or die(mysqli_error($con));

    mysqli_query($con, "UPDATE tbl_dosen SET nama = '$name' WHERE nik = '$username'")or die(mysqli_error($con));

    mysqli_query($con, "UPDATE tbl_mahasiswa SET nama = '$name' WHERE nim = '$username'")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../admin_data_administrator"</script>';
    
}
?>