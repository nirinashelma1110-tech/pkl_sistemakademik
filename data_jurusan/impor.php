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
       $kode_jurusan = $data_excel[$i]['B'];
       $nama_jurusan = $data_excel[$i]['C'];

        // cek kode jurusan di database
       $query_cek = mysqli_query($con, "SELECT kode_jurusan FROM tbl_jurusan WHERE kode_jurusan='$kode_jurusan'")
       or die(mysqli_error($con));

       // ketika data kode matkul tidak ada 
       if (mysqli_num_rows($query_cek)==0) {
         $query_insert = mysqli_query($con, "INSERT INTO tbl_jurusan VALUES ('$kode_jurusan', '$nama_jurusan')")or die(mysqli_error($con));
       }

    }

    echo '<script>
    alert("Data Berhasil Diimport");
     window.location.href = "../data_jurusan";
    </script>';

}

    
?>