<?php
require_once '../database/koneksi.php';

$authority = @$_SESSION['peran'];
if($authority != 'A'){
    echo '<script>
        window.location.href = "../logout.php";
        alert("Anda bukan admin!!! Akan segera di logout-kan");
    </script>';
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($con, "SELECT status FROM tbl_pertemuan WHERE id = '$id'");
    $data_status = mysqli_fetch_assoc($query);

    if ($data_status) {
        $status_sekarang = $data_status['status'];
        if ($status_sekarang == '1') {
            $status_baru = '0';
        } else {
            $status_baru = '1';
        }
        $query_update = mysqli_query($con, "UPDATE tbl_pertemuan SET status = '$status_baru' WHERE id = '$id'")or die(mysqli_error($con));

        if ($query_update) {
            echo '<script>
                window.location.href="../kelas_matakuliah/presensi.php?id='.$id.'";
            </script>';
        } else {
            echo '<script>
                window.location.href="../kelas_matakuliah/presensi.php?id='.$id.'";
            </script>';
        }
    } else {
        echo '<script>
                alert("Data presensi tidak ditemukan!");
                window.location.href="../kelas_matakuliah/presensi.php?id='.$id.'";
            </script>';
    }
}

?>