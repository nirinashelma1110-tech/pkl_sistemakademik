<?php
require '../asset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once '../database/koneksi.php';

if (isset($_POST['btn_impor'])){ // cek apakah button sudah diklik 

    $kode_kelas = mysqli_real_escape_string($con, $_POST['kode_kelas']);

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
       $akd = $data_excel[$i]['B'];
       $matkul = $data_excel[$i]['C'];
       $jurusan = $data_excel[$i]['D'];
       $nik = $data_excel[$i]['E'];
       $nama_kelas = $data_excel[$i]['F'];
       $mahasiswa = $data_excel[$i]['G'];

       
       $cek_kelas_mk = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_akd = '$akd' 
       AND kode_matkul = '$matkul'
       AND kode_jurusan = '$jurusan'
       AND nik = '$nik'
       AND nama_kelas = '$nama_kelas'
       ")or die(mysqli_error($con));

       $rv = mysqli_num_rows($cek_kelas_mk);
       if ($akd == '' || $matkul == '' || $jurusan == '' || $nik == '' || $nama_kelas == '' ) {
        continue;
       } else {
        $cek_mahasiswa = mysqli_query($con, "SELECT nim FROM tbl_mahasiswa WHERE nim= '$mahasiswa'")or die(mysqli_error($con));
        $rv_mahasiswa = mysqli_num_rows($cek_mahasiswa);



       if ($rv == 0) {
            $tambah_kelas_mk = mysqli_query($con, "INSERT INTO tbl_kelas_matkul VALUES
            (null,
            '$akd',
            '$matkul',
            '$jurusan',
            '$nik',
            '$nama_kelas')
            ")or die(mysqli_error($con));
            $kode_kls = mysqli_insert_id($con);


            if ($rv_mahasiswa > 0) {
                $insert_mahasiswa = mysqli_query($con, "INSERT INTO tbl_detail_kelas VALUES
                (null,
                '$kode_kls',
                '$mahasiswa')
                ")or die(mysqli_error($con));
            } else {
                continue;
            }


            } else {
                    $dt = mysqli_fetch_assoc($cek_kelas_mk);
                    $kode_kelas = $dt['kode_kelas'];
                    if ($rv_mahasiswa){
                        $insert_mahasiswa = mysqli_query($con, "INSERT INTO tbl_detail_kelas VALUES
                    (null,
                    '$kode_kls',
                    '$mahasiswa')
                    ")or die(mysqli_error($con));

                    }else {
                        continue;
                    }
                    
            }
        }
    }

echo '<script>
    alert("Data Berhasil Diimport");
     window.location.href = "../kelas_matakuliah/";
    </script>';
}
    
?>