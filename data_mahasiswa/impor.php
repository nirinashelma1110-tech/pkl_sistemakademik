<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){ // cek apakah button sudah diklik 
    $file = $_FILES['file_excel']['name']; // nampung nama yang diupload
    $extention = explode('.', $file); //pisahkan ektensi dari nama
   
    $nama_file = 'file'.round(microtime(true)).'.'.end($extention); // buat nama file baru

    $alamat_tujuan = 'template/'.$nama_file;  // buat alamat tujuan untuk menyimpan file
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];  // alamat sumber file yang diupload
    move_uploaded_file($file_alamat_sumber,$alamat_tujuan); // pindahh file ke projek
   
    $file_excel = PHPExcel_IOFactory :: load($alamat_tujuan); //baca excel file

    $data_excel = $file_excel-> getActiveSheet()->toArray(null, true, true, true); // baca data excel dibuat menjadi array

    for ($i=2; $i <= count($data_excel) ; $i++) { //perulangan
    // tampung data dari excel
       $nim = $data_excel[$i]['B'];
       $nama = $data_excel[$i]['C'];
       $kontak = $data_excel[$i]['D'];
       $email = $data_excel[$i]['E'];
       $kelamin = $data_excel[$i]['F'];

       $img = '../asset_web/image/mhs_lakilaki.png';

        // cek kode matkul di database
       $query_cek = mysqli_query($con, "SELECT nim FROM tbl_mahasiswa WHERE nim='$nim'")
       or die(mysqli_error($con));

       // ketika data kode matkul tidak ada 
       if (mysqli_num_rows($query_cek)==0) {
         $query_insert = mysqli_query($con, "INSERT INTO tbl_mahasiswa VALUES ('$nim', '$nama', '$kontak', '$email', '$kelamin', '$img')")or die(mysqli_error($con));

         $username = $nim;
            $sandi = sha1($nim);
            $peran = 'M';
            $pin = 1234;
            $query_pengguna = mysqli_query($con, "INSERT INTO tbl_user (username, sandi, peran, pin, nama) VALUES ('$username', '$sandi', '$peran', '$pin', '$nama')") or die(mysqli_error($con));
       }

    }

    echo '<script>
    alert("Data Berhasil Diimport");
     window.location.href = "../data_mahasiswa";
    </script>';

}

    
?>