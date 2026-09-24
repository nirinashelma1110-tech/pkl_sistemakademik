<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $id  = trim(mysqli_real_escape_string($con, $_POST['presensi']) );
    $status_kehadiran  = trim(mysqli_real_escape_string($con, $_POST['status_kehadiran']) );
    $id_pertemuan  = trim(mysqli_real_escape_string($con, $_POST['id_pertemuan']) );

    $query_edit = mysqli_query($con,"UPDATE tbl_presensi SET
    status_kehadiran = '$status_kehadiran'
    WHERE id = '$id'
     ")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../kelas_matakuliah/presensi.php?id='.$id_pertemuan.'"</script>';
    
}
?>