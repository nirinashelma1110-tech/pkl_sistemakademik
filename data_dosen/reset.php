

<?php 
    require_once '../database/koneksi.php';
    $query_reset = mysqli_query($con, "TRUNCATE TABLE tbl_dosen") or die (mysqli_error($con));
    $query_pengguna = mysqli_query($con, "DELETE FROM tbl_user WHERE peran = 'D'") or die (mysqli_error($con));

    if ($query_reset && $query_pengguna) {
        echo '
        <script>
            alert("Data Mahasiswa Telah Direset");
            window.location.href="../data_dosen";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($con, mysqli_error($con));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../data_dosen";
        </script>';
    }
?>