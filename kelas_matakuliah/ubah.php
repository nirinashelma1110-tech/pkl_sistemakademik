<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_kelas  = trim(mysqli_real_escape_string($con, $_POST['kode_kelas']) );
    $kode_akd  = trim(mysqli_real_escape_string($con, $_POST['kode_akd']) );
    $kode_matkul  = trim(mysqli_real_escape_string($con, $_POST['kode_matkul']) );
    $kode_jurusan  = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']) );
    $nik  = trim(mysqli_real_escape_string($con, $_POST['nik']) );
    $nama_kelas  = trim(mysqli_real_escape_string($con, $_POST['nama_kelas']) );
    

    $query_edit = mysqli_query($con,"UPDATE tbl_kelas_matkul SET
    kode_kelas = '$kode_kelas',
    kode_akd = '$kode_akd',
    kode_jurusan = '$kode_jurusan',
    kode_matkul = '$kode_matkul',
    nik = '$nik',
    nama_kelas = '$nama_kelas'
    WHERE kode_kelas = '$kode_kelas'
     ")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../kelas_matakuliah"</script>';
    
}
?>