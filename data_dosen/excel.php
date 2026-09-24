<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Dosen-" . date('Y-m-d');
$query_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen")or die(mysqli_error($con));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Dosen');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'NIK');
$sheet->setCellValue('C1', 'NAMA DOSEN');
$sheet->setCellValue('D1', 'KONTAK');
$sheet->setCellValue('E1', 'EMAIL');
$sheet->setCellValue('F1', 'KELAMIN');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:C1')->applyFromArray($styleArray);
$sheet->getStyle('A1:C1')->getFont()->setBold(true);

foreach (array('B', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_dosen)) {
    $code = $data['nik'];
    $nama = $data['nama'];
    $kontak = $data['kontak'];
    $email = $data['email'];
    $kelamin = $data['kelamin'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $code);
    $sheet->setCellValue("C" . $rowNumber, $nama);
     $sheet->setCellValue("D" . $rowNumber, $kontak);
      $sheet->setCellValue("E" . $rowNumber, $email);
       $sheet->setCellValue("F" . $rowNumber, $kelamin);
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