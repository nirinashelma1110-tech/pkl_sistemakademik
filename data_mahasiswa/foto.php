<?php
require_once '../database/koneksi.php';

if(isset ($_POST['btn_foto'])) { //cek button
    $nim = trim(mysqli_real_escape_string($con, $_POST['nim'])); //tampung nim
    $file =$_FILES['file_foto']['name'];
    $extention = explode('.',$file);
    $nama_file = 'foto-mhs'.round(microtime(true)).'.'.end($extention);
    $alamat_sumber = $_FILES['file_foto']['tmp_name'];
    $alamat_tujuan = '../asset_web/image/'.$nama_file;
    move_uploaded_file($alamat_sumber, $alamat_tujuan);

    $query_edit_foto = mysqli_query($con, "UPDATE tbl_mahasiswa SET img='$alamat_tujuan' WHERE nim='$nim'")or die(mysqli_error($con));

    echo '<script>
    alert("Foto Berhasil Diupdate");
     window.location.href = "../data_mahasiswa";
    </script>';

}

?>


