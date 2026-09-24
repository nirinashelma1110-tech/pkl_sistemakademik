<?php
require_once '../database/koneksi.php';
require('../asset_web/fpdf19/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../asset_web/image/logo.png', 10, 15, 40); // ..,utk kebawah atas logo,..
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80); //dari pojok kiri ke tengah/lebar/kotak
        // Title
        $this->Cell(30, 7, 'Fakultas Sains Dan Teknologi', 0, 2, 'C'); //panjang,lebar atasbawah,title,border/kotak,..,center
        
        // Title
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(30, 8, 'Prodi Sistem Informasi', 0, 2, 'C'); //panjang,lebar atasbawah,title,border/kotak,..,center
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, 'Jalan Raya No.KM.3, Glempang, Pagojengan, Kec. Paguyangan', 0, 2, 'C');
        $this->Cell(30, 5, 'kabupaten Brebes, Jawa Tengah 52276', 0, 0, 'C');
        // Line break
        $this->SetLineWidth(1);
        $this->Line(10, 37, 200, 37);
        //Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$kode_kelas = @$_GET['id'];
$querry_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($con));
;
$data_kelas = mysqli_fetch_array($querry_kelas);

$nik = $data_kelas['nik'];
$querry_dosen = mysqli_query($con, "SELECT nama FROM tbl_dosen WHERE nik='$nik'")or die(mysqli_error($con));
;
$nama_dosen = mysqli_fetch_assoc($querry_dosen)['nama'];

$kode_matkul = $data_kelas['kode_matkul'];
$querry_matkul = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'")or die(mysqli_error($con));
;
$nama_matkul = mysqli_fetch_assoc($querry_matkul)['nama_matkul'];

$kode_akd = $data_kelas['kode_akd'];
$querry_akd = mysqli_query($con, "SELECT tahun, semester FROM tbl_akademik WHERE kode_akd='$kode_akd'")or die(mysqli_error($con));
;
$data_akd = mysqli_fetch_assoc($querry_akd);
$periode = $data_akd['tahun'] . " - " . ($data_akd['semester'] == 'GL' ? 'Ganjil' : 'Genap');

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 7, 'LAPORAN PRESENSI', 0, 1, 'C');
$pdf->Ln(5);

$pdf->Setfont('Times', '', 12);
$pdf->Cell(25, 6, 'Mata Kuliah', 0, 0); 
$pdf->Cell(85, 6, ': '.$nama_matkul, 0, 0);
$pdf->Cell(25, 6, 'Nama Kelas', 0, 0); 
$pdf->Cell(50, 6, ': '.$data_kelas['nama_kelas'], 0, 1);

$pdf->Cell(25, 6, 'Dosen', 0, 0); 
$pdf->Cell(85, 6, ': '.$nama_dosen, 0, 0);
$pdf->Cell(25, 6, 'Periode', 0, 0); 
$pdf->Cell(50, 6, ': '.$periode, 0, 1);
$pdf->Ln(5);

$querry_pertemuan = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE kode_kelas = '$kode_kelas'")or die(mysqli_error($con));
;

while($meet = mysqli_fetch_array($querry_pertemuan)){
    $id_pertemuan = $meet['id'];

    $pdf->SetFont('Times', 'B', 11);
    
    $judul_meet = 'Pertemuan Ke-'.$meet['pertemuan_ke'].' : '.$meet['judul_pertemuan'].' (Tgl: '.$meet['tanggal'].')';
    $pdf->Cell(190, 8, $judul_meet, 1, 1, 'L', false);

    $pdf->SetFont('Times', 'B', 11);
    $pdf->Cell(10, 7, 'No', 1, 0, 'C');
    $pdf->Cell(35, 7, 'NIM', 1, 0, 'C');
    $pdf->Cell(100, 7, 'Nama Mahasiswa', 1, 0, 'C');
    $pdf->Cell(45, 7, 'Status Kehadiran', 1, 1, 'C');

    $pdf->SetFont('Times', '', 11);
   
    $querry_presensi = mysqli_query($con, "SELECT nim, status_kehadiran FROM tbl_presensi WHERE id_pertemuan = '$id_pertemuan'")or die(mysqli_error($con));
;
    
    $no = 1;
    $jml_hadir = 0;

    if(mysqli_num_rows($querry_presensi) > 0){
        while($absen = mysqli_fetch_array($querry_presensi)){
            $nim_absen = $absen['nim'];
            $status = ucfirst($absen['status_kehadiran']);
            
            if(strtolower($absen['status_kehadiran']) == 'hadir'){
                $jml_hadir++;
            }

            $querry_mhs = mysqli_query($con, "SELECT nama FROM tbl_mahasiswa WHERE nim = '$nim_absen'")or die(mysqli_error($con));
;
            $data_mhs = mysqli_fetch_array($querry_mhs);
            $nama_mhs = $data_mhs['nama'];

            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(35, 6, $nim_absen, 1, 0, 'C');
            $pdf->Cell(100, 6, ' '.$nama_mhs, 1, 0, 'L');
            $pdf->Cell(45, 6, $status, 1, 1, 'C');
        }
    }
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(190, 6, 'Jumlah Hadir : '.$jml_hadir, 0, 1, 'L');
    $pdf->Ln(3);
}
$pdf->Output();
?>