<?php
require_once '../database/koneksi.php';

if(isset($_GET['id_pertemuan'])){
    $id_pertemuan = @$_GET['id_pertemuan'];
    $nim = $_SESSION['username'];

    $ambil_status_pertemuan = mysqli_query($con, "SELECT status FROM tbl_pertemuan WHERE id = '$id_pertemuan'")or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($ambil_status_pertemuan);
    $status_pertemuan = $data_pertemuan['status'];
}

if ($status_pertemuan == 0) {
     echo '
          <script>
          alert("Presensi Telah Ditutup");
          window.location.href = "../presensi_mahasiswa"
    </script>';
} else {
    $querry_status_kehadiran = mysqli_query($con, "SELECT status_kehadiran FROM tbl_presensi WHERE id_pertemuan = '$id_pertemuan' AND nim='$nim'")or die(mysqli_error($con));
    $data_status_kehadiran = mysqli_fetch_array($querry_status_kehadiran);
    $status_kehadiran = $data_status_kehadiran['status_kehadiran'];
    if ($status_kehadiran == 'hadir') {
        echo '
          <script>
          alert("Anda Telah Melakukan Presensi di Pertemuan Ini");
          window.location.href = "../presensi_mahasiswa"
    </script>';
    } else {
        $status_hadir = 'hadir';
        $query_update = mysqli_query($con, "UPDATE tbl_presensi SET status_kehadiran = '$status_hadir' WHERE id_pertemuan = '$id_pertemuan' AND nim='$nim'")or die(mysqli_error($con));
        echo '
          <script>
          alert("Anda Berhasil Melakukan Presensi");
          window.location.href = "../presensi_mahasiswa"
    </script>';
    }
}


?>

