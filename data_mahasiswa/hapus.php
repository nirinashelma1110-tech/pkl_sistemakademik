<html>
    <head>
    </head>
    <body>
       <?php
       session_start();
       require_once '../database/koneksi.php';
       
       // Mengamankan input dari URL
       $pengguna = mysqli_real_escape_string($con, @$_GET['user']);

       // 1. Hapus data dari tbl_mahasiswa
       mysqli_query($con, "DELETE FROM tbl_mahasiswa WHERE nim='$pengguna'") or die(mysqli_error($con));
       
       // 2. Otomatis hapus akun loginnya di tbl_user
       mysqli_query($con, "DELETE FROM tbl_user WHERE username='$pengguna'") or die(mysqli_error($con));

        echo '<script> alert("Data Mahasiswa '.$pengguna.' beserta akun loginnya Berhasil Dihapus!!!!!");
            window.location.href="../data_mahasiswa";
        </script>';
       ?> 
    </body>
</html>