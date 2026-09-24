<html>
    <head>
    </head>
    <body>
       <?php
       session_start();
       require_once '../database/koneksi.php';
       $pengguna_login = $_SESSION['nik'];
       
       // Mengamankan input dari URL
       $pengguna = mysqli_real_escape_string($con, @$_GET['user']);

       $cek_admin = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM tbl_dosen") or die(mysqli_error($con));
       $data = mysqli_fetch_assoc($cek_admin);
       $jumlah = $data['jumlah'];

       if ($pengguna_login == $pengguna && $jumlah == 1) {
            echo '<script> alert("Anda Tidak Dapat Menghapus Akun Diri Anda Sendiri");
            window.location.href="../data_dosen";
            </script>';
       } else {
           // 1. Hapus dari tbl_dosen
           mysqli_query($con, "DELETE FROM tbl_dosen WHERE nik='$pengguna'") or die(mysqli_error($con));
           
           // 2. Otomatis hapus akun loginnya di tbl_user
           mysqli_query($con, "DELETE FROM tbl_user WHERE username='$pengguna'") or die(mysqli_error($con));

            echo '<script> alert("Data Dosen '.$pengguna.' beserta akun loginnya Berhasil Dihapus!!!!!");
                window.location.href="../data_dosen";
            </script>';
       }
       ?> 
    </body>
</html>