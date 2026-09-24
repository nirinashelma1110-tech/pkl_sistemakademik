<?php
require_once '../database/koneksi.php';
require('../asset_web/fpdf19/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../asset_web/image/logo.png', 10, 13, 40);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 7, 'FAKULTAS SAINS DAN TEKNOLOGI', 0, 2, 'C');
        
        // Title
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(30, 8, 'Prodi Sistem Informasi', 0, 2, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, 'Jln. Raya Pagojengan KM.3 Pagojengan, Paguyangan', 0, 2, 'C');
        $this->Cell(30, 5, 'Kabupaten Brebes, Jawa Tengah 52276', 0, 0, 'C');
        // Line break
        $this->SetLineWidth(1);
        $this->Line(10, 37, 200, 37);
        // Line break
        $this->Ln(15);
        
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

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(80);
$pdf->Cell(30, 7, 'Data Dosen', 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(10, 7, 'No', 1, 0, 'C');
$pdf->Cell(25, 7, 'NIK', 1, 0, 'C');
$pdf->Cell(50, 7, 'Nama Dosen', 1, 0, 'C');
$pdf->Cell(30, 7, 'Kontak', 1, 0, 'C');
$pdf->Cell(45, 7, 'Email', 1, 0, 'C');
$pdf->Cell(27, 7, 'Jenis Kelamin', 1, 1, 'C');

$query_ambil_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen")or die(mysqli_error($con));
$rv = mysqli_num_rows($query_ambil_dosen);
if ($rv > 0) {
    $no = 1;
    while ($data = mysqli_fetch_array($query_ambil_dosen)) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(25, 7, $data['nik'], 1, 0, 'C');
        $pdf->Cell(50, 7, $data['nama'], 1, 0, 'L');
        $pdf->Cell(30, 7, $data['kontak'], 1, 0, 'C');
        $pdf->Cell(45, 7, $data['email'], 1, 0, 'C');
        $pdf->Cell(27, 7, ($data['kelamin'] == 'L') ? 'Laki-laki' : "Perempuan", 1, 1, 'C');
    }
}
$pdf->Output();
?>
