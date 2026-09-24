<?php
// Hubungkan ke database sesuai dengan path yang sudah benar
require_once '../database/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Tangkap data dari form
    $username   = $_POST['username']; 
    $peran      = $_POST['peran'];
    $pin        = $_POST['pin'];
    $password   = $_POST['password'];
    $konfirmasi = $_POST['repassword']; 

    // Validasi: Cek apakah password dan konfirmasi password cocok
    if ($password !== $konfirmasi) {
        echo "<script>
                alert('Gagal: Password dan Konfirmasi Password tidak cocok!');
                window.location.href='index.php';
              </script>";
        exit;
    }

    // LOGIKA CEK DUPLIKAT DATA (Mencegah username yang sama)
    $cek_username = mysqli_query($con, "SELECT * FROM tbl_user WHERE username = '$username'");

    if (mysqli_num_rows($cek_username) > 0) {
        // Pop-up jika data sudah ada di database
        echo "<script>
                alert('Data Sudah Ada, Silakan Login Ulang');
                window.location.href='index.php';
              </script>";
    } else {
        // LOGIKA SIMPAN DATA (Jika username belum ada)
        $query_simpan = "INSERT INTO tbl_user (username, peran, pin, password) 
                         VALUES ('$username', '$peran', '$pin', '$password')";
        
        $simpan = mysqli_query($con, $query_simpan);

        if ($simpan) {
            echo "<script>
                    alert('Berhasil: Data user baru telah tersimpan!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal: Terjadi kesalahan saat menyimpan data.');
                    window.location.href='index.php';
                  </script>";
        }
    }
}
?>