<?php
session_start();
require_once '../database/koneksi.php';

// Ambil parameter kode mata kuliah dari URL (misal: hapus.php?kode=101)
$kode_matkul = @$_GET['user'];

// Jika parameter kode kosong, kembalikan ke halaman data mata kuliah
if (empty($kode_matkul)) {
    header("Location: ../data_matakuliah/");
    exit;
}

// Cek apakah data mata kuliah dengan kode tersebut ada di database
$cek_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($con));

if (mysqli_num_rows($cek_matkul) > 0) {
    // Eksekusi perintah hapus data mata kuliah
    $delete = mysqli_query($con, "DELETE FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($con));

    if ($delete) {
        echo '<script>
            alert("Data Mata Kuliah dengan Kode ' . $kode_matkul . ' Berhasil Dihapus!");
            window.location.href = "../data_matakuliah/";
        </script>';
    }
} else {
    echo '<script>
        alert("Gagal: Data Mata Kuliah tidak ditemukan!");
        window.location.href = "../data_matakuliah/";
    </script>';
}
?>