<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {

    $kode_jurusan  = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']) );
    $nama_jurusan  = trim(mysqli_real_escape_string($con, $_POST['nama_jurusan']) );
    

    $query_edit = mysqli_query($con,"UPDATE tbl_jurusan SET
    nama_jurusan = '$nama_jurusan'
    WHERE kode_jurusan = '$kode_jurusan'
     ")or die(mysqli_error($con));

     mysqli_query($con, "UPDATE tbl_user SET nama = '$nama_jurusan' WHERE username = '$kode_jurusan'")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../data_jurusan"</script>';
    
}
?>