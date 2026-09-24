<?php
require_once '../database/koneksi.php';

if(isset ($_POST['btn_foto'])) { //cek button
    $nik = trim(mysqli_real_escape_string($con, $_POST['nik'])); //tampung nik
    $file =$_FILES['file_foto']['name'];
    $extention = explode('.',$file);
    $nama_file = 'foto-mhs'.round(microtime(true)).'.'.end($extention);
    $alamat_sumber = $_FILES['file_foto']['tmp_name'];
    $alamat_tujuan = '../asset_web/image/'.$nama_file;
    move_uploaded_file($alamat_sumber, $alamat_tujuan);

    $query_edit_foto = mysqli_query($con, "UPDATE tbl_dosen SET img='$alamat_tujuan' WHERE nik='$nik'")or die(mysqli_error($con));

    echo '<script>
    alert("Foto Berhasil Diupdate");
     window.location.href = "../data_dosen";
    </script>';

}

?>


