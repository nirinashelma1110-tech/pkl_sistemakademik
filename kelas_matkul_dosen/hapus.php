<?php 
    require_once '../database/koneksi.php';
    $id = @$_GET['user'];

    if (empty($id)) {
        echo '<script>alert("Data tidak valid!"); window.location.href="../kelas_matkul_dosen";</script>';
        exit;
    }

    $query_cari_kelas = mysqli_query($con, "SELECT kode_kelas FROM tbl_detail_kelas WHERE id = '$id'");
    $data_kelas = mysqli_fetch_assoc($query_cari_kelas);
    
    if ($data_kelas) {
        $kode_kelas = $data_kelas['kode_kelas'];

        $hapus_detail = mysqli_query($con, "DELETE FROM tbl_detail_kelas WHERE id = '$id'") or die (mysqli_error($con));
        
        if ($hapus_detail) {
            echo '
            <script>
                alert("Mahasiswa dengan NIM ' . $nim . ' Berhasil Dihapus dari Kelas");
                window.location.href="index.php?user=' . $kode_kelas . '";
            </script>';
        } else {
            $error_msg = mysqli_real_escape_string($con, mysqli_error($con));
            echo '
            <script>
                alert("Gagal menghapus data: ' . $error_msg . '");
                window.location.href="index.php?user=' . $kode_kelas . '";
            </script>';
        }
    } else {
         echo '<script>alert("Data tidak ditemukan di kelas manapun!"); window.location.href="../kelas_matkul_dosen";</script>';
    }
?>