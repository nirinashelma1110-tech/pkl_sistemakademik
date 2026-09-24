<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {

    $nim  = trim(mysqli_real_escape_string($con, $_POST['nim']) );
    $name  = trim(mysqli_real_escape_string($con, $_POST['name']) );
    $kontak  = trim(mysqli_real_escape_string($con, $_POST['kontak']) );
    $email  = trim(mysqli_real_escape_string($con, $_POST['email']) );
    $kelamin  = trim(mysqli_real_escape_string($con, $_POST['kelamin']) );
    

    $query_edit = mysqli_query($con,"UPDATE tbl_mahasiswa SET
    nama = '$name',
    kontak = '$kontak',
    email = '$email',
    kelamin = '$kelamin' WHERE nim = '$nim'
     ")or die(mysqli_error($con));

    mysqli_query($con, "UPDATE tbl_user SET nama = '$name' WHERE username = '$nim'")or die(mysqli_error($con));


    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../data_mahasiswa"</script>';
    
}
?>