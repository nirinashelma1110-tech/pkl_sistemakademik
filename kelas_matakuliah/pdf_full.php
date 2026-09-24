<?php
require_once '../database/koneksi.php';
require('../asset_web/fpdf19/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../asset_web/image/logo.png', 10, 15, 40); 
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80); 
        // Title
        $this->Cell(30, 7, 'Fakultas Sains Dan Teknologi', 0, 2, 'C'); 
        
        // Title
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(30, 8, 'Prodi Sistem Informasi', 0, 2, 'C'); 
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

$kode_kelas = isset($_GET['id']) ? $_GET['id'] : '';
if (empty($kode_kelas)) {
    die("Error: ID Kelas tidak ditemukan.");
}

$querry_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_kelas = '$kode_kelas'") or die(mysqli_error($con));
$data_kelas = mysqli_fetch_array($querry_kelas);

if (!$data_kelas) {
    die("Error: Data kelas tidak ditemukan.");
}

$nik = $data_kelas['nik'];
$querry_dosen = mysqli_query($con, "SELECT nama FROM tbl_dosen WHERE nik='$nik'") or die(mysqli_error($con));
$data_dosen = mysqli_fetch_assoc($querry_dosen);
$nama_dosen = $data_dosen ? $data_dosen['nama'] : '-';

$kode_matkul = $data_kelas['kode_matkul'];
$querry_matkul = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'") or die(mysqli_error($con));
$data_matkul = mysqli_fetch_assoc($querry_matkul);
$nama_matkul = $data_matkul ? $data_matkul['nama_matkul'] : '-';

$kode_akd = $data_kelas['kode_akd'];
$querry_akd = mysqli_query($con, "SELECT tahun, semester FROM tbl_akademik WHERE kode_akd='$kode_akd'") or die(mysqli_error($con));
$data_akd = mysqli_fetch_assoc($querry_akd);
$periode = $data_akd ? ($data_akd['tahun'] . " - " . ($data_akd['semester'] == 'GL' ? 'Ganjil' : 'Genap')) : '-';


$arr_id_pertemuan = [];
$querry_ptm = mysqli_query($con, "SELECT id FROM tbl_pertemuan WHERE kode_kelas = '$kode_kelas'");
while ($row_ptm = mysqli_fetch_assoc($querry_ptm)) {
    $arr_id_pertemuan[] = $row_ptm['id'];
}
$total_pertemuan = count($arr_id_pertemuan);
$in_id_pertemuan = $total_pertemuan > 0 ? implode(',', $arr_id_pertemuan) : '0';

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(0, 7, 'REKAP PRESENSI KELAS', 0, 1, 'C');
$pdf->Ln(4);


$pdf->Setfont('Times', '', 11);
$pdf->Cell(25, 6, 'Mata Kuliah', 0, 0); 
$pdf->Cell(85, 6, ': '.$nama_matkul, 0, 0);
$pdf->Cell(25, 6, 'Nama Kelas', 0, 0); 
$pdf->Cell(55, 6, ': '.$data_kelas['nama_kelas'], 0, 1);

$pdf->Cell(25, 6, 'Dosen', 0, 0); 
$pdf->Cell(85, 6, ': '.$nama_dosen, 0, 0);
$pdf->Cell(25, 6, 'Periode', 0, 0); 
$pdf->Cell(55, 6, ': '.$periode, 0, 1);

$pdf->Cell(25, 6, 'Jml Pertemuan', 0, 0); 
$pdf->Cell(85, 6, ': '.$total_pertemuan.' Pertemuan', 0, 1);
$pdf->Ln(5);


$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'NIM', 1, 0, 'C');
$pdf->Cell(65, 8, 'Nama Mahasiswa', 1, 0, 'C');
$pdf->Cell(25, 8, 'Total Hadir', 1, 0, 'C');
$pdf->Cell(30, 8, '% Kehadiran', 1, 0, 'C');
$pdf->Cell(30, 8, 'Nilai Kontrak', 1, 1, 'C');


$pdf->SetFont('Times', '', 9);

$arr_nim = [];
if ($total_pertemuan > 0) {
    $querry_mhs_presensi = mysqli_query($con, "SELECT DISTINCT nim FROM tbl_presensi WHERE id_pertemuan IN ($in_id_pertemuan)");
    
    if ($querry_mhs_presensi && mysqli_num_rows($querry_mhs_presensi) > 0) {
        while ($row_mhs = mysqli_fetch_assoc($querry_mhs_presensi)) {
            $arr_nim[] = $row_mhs['nim'];
        }
    }
}

$no = 1;

if ($total_pertemuan > 0 && count($arr_nim) > 0) {
    foreach ($arr_nim as $nim) {
        
        $q_mhs = mysqli_query($con, "SELECT nama FROM tbl_mahasiswa WHERE nim = '$nim'");
        $d_mhs = mysqli_fetch_assoc($q_mhs);
        $nama_mhs = $d_mhs ? $d_mhs['nama'] : '-';

        $count_status = function($status_name) use ($con, $in_id_pertemuan, $nim) {
            $q = mysqli_query($con, "
                SELECT COUNT(*) AS total 
                FROM tbl_presensi 
                WHERE id_pertemuan IN ($in_id_pertemuan) 
                AND nim = '$nim' 
                AND LOWER(status_kehadiran) = '$status_name'
            ");
            $d = mysqli_fetch_assoc($q);
            return $d ? $d['total'] : 0;
        };

        
        $jml_hadir = $count_status('hadir');
        
        $persen_kehadiran = ($total_pertemuan > 0) ? ($jml_hadir / $total_pertemuan) * 100 : 0;
        $persen_kontrak = ($total_pertemuan > 0) ? ($jml_hadir / $total_pertemuan) * 15 : 0;

        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(30, 7, $nim, 1, 0, 'C');
        $pdf->Cell(65, 7, ' '.$nama_mhs, 1, 0, 'L');
        $pdf->Cell(25, 7, $jml_hadir, 1, 0, 'C');
        $pdf->Cell(30, 7, number_format($persen_kehadiran, 1) . ' %', 1, 0, 'C');
        $pdf->Cell(30, 7, number_format($persen_kontrak, 1) . ' %', 1, 1, 'C');
        
    }
} else {
    $pdf->Cell(190, 8, 'Belum ada data mahasiswa atau pertemuan tercatat untuk kelas ini.', 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Rekap_Presensi.pdf');
?>