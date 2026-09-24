<html>
    <head>

    </head>
    <body>
       <?php
       session_start();
       require_once  '../database/koneksi.php';
       $pengguna_login = $_SESSION['username'];
       $pengguna = @$_GET['user'];

       if (empty($pengguna)) {
        header("Location:../admin_data_administrator/");
        exit;
       }

        $cek_admin = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM tbl_user WHERE peran= 'A'")or die(mysqli_error($con));

        $data = mysqli_fetch_assoc($cek_admin);
        $jumlah = $data['jumlah'];

        $cek_target = mysqli_query($con, "SELECT peran FROM tbl_user WHERE username = '$pengguna'")or die(mysqli_error($con));
        $data_target = mysqli_fetch_assoc($cek_target);
        $peran_target = $data_target['peran'];


       if ($pengguna_login == $pengguna) {
            echo '<script>alert("Gagal: Anda tidak dapat menghapus akun Anda sendiri saat sedang login!"); window.location.href="../admin_data_administrator/";</script>';
        } elseif ($peran_target == 'A' && $jumlah <= 1) {
            echo '<script>alert("Gagal: Akun Admin ini adalah satu-satunya yang tersisa dan tidak boleh dihapus!"); window.location.href="../admin_data_administrator/";</script>';
        } else {
            
            // --- TAMBAHAN LOGIKA SINKRONISASI HAPUS ---
            if ($peran_target == 'M') {
                // Jika yang dihapus adalah Mahasiswa, hapus juga data di tabel mahasiswa (nim = username)
                mysqli_query($con, "DELETE FROM tbl_mahasiswa WHERE nim = '$pengguna'") or die(mysqli_error($con));
            } elseif ($peran_target == 'D') {
                // Jika yang dihapus adalah Dosen, hapus juga data di tabel dosen (nik = username)
                mysqli_query($con, "DELETE FROM tbl_dosen WHERE nik = '$pengguna'") or die(mysqli_error($con));
            }

            // Setelah profil terhapus, baru hapus akun loginnya
            mysqli_query($con, "DELETE FROM tbl_user WHERE username = '$pengguna'") or die (mysqli_error($con));
            
            echo '
            <script>
                alert("Data Pengguna '.$pengguna.' beserta profilnya Berhasil Dihapus!");
                window.location.href="../admin_data_administrator/";
            </script>';
        }
        ?> 
    </body>


</html>