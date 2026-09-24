<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Kelas-" . date('Y-m-d');
$query_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul")or die(mysqli_error($con));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Kelas');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'KODE AKADEMIK');
$sheet->setCellValue('C1', 'KODE MATKUL');
$sheet->setCellValue('D1', 'KODEJURUSAN');
$sheet->setCellValue('E1', 'NIK');
$sheet->setCellValue('F1', 'NAMA KELAS');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:F1')->applyFromArray($styleArray);
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D', 'F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_kelas)) {
    $code = $data['kode_akd'];
    $matkul = $data['kode_matkul'];
    $jurusan = $data['kode_jurusan'];
    $nik = $data['nik'];
    $kelas = $data['nama_kelas'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $code);
    $sheet->setCellValue("C" . $rowNumber, $matkul);
     $sheet->setCellValue("D" . $rowNumber, $jurusan);
      $sheet->setCellValue("E" . $rowNumber, $nik);
       $sheet->setCellValue("F" . $rowNumber, $kelas);
    $rowNumber++;
    $no++;
}

// Buat file excel
$filename = $nama_file . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>