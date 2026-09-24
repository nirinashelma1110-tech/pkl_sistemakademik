

<?php 
    require_once '../database/koneksi.php';
    $query_reset = mysqli_query($con, "TRUNCATE TABLE tbl_matkul") or die (mysqli_error($con));
    
    if ($query_reset) {
        echo '
        <script>
            alert("Data Mata Kuliah Telah Direset");
            window.location.href="../data_matakuliah";
        </script>';
    } else {
        $error_msg = mysqli_real_escape_string($con, mysqli_error($con));
        echo '
        <script>
            alert("Gagal menghapus data: ' . $error_msg . '");
            window.location.href="../data_matakuliah";
        </script>';
    }
?>