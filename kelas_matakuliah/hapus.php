<html>
    <head>
    </head>
    <body>
       <?php
       session_start();
       require_once '../database/koneksi.php';
       $pengguna_login = $_SESSION['kode_kelas'];
       
       // Mengamankan input dari URL
       $pengguna = mysqli_real_escape_string($con, @$_GET['user']);

       $cek_admin = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM tbl_kelas_matkul") or die(mysqli_error($con));
       $data = mysqli_fetch_assoc($cek_admin);
       $jumlah = $data['jumlah'];

       if ($pengguna_login == $pengguna && $jumlah == 1) {
            echo '<script> alert("Anda Tidak Dapat Menghapus Akun Diri Anda Sendiri");
            window.location.href="../kelas_matakuliah";
            </script>';
       } else {
           // 1. Hapus dari tbl_kelas_matkul
           mysqli_query($con, "DELETE FROM tbl_kelas_matkul WHERE kode_kelas='$pengguna'") or die(mysqli_error($con));
           
         
            echo '<script> alert("Data Berhasil Dihapus!!!!!");
                window.location.href="../kelas_matakuliah";
            </script>';
       }
       ?> 
    </body>
</html>