<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Akademik-" . date('Y-m-d');
$query_dosen = mysqli_query($con, "SELECT * FROM tbl_akademik")or die(mysqli_error($con));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Akademik');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'KODE AKADEMIK');
$sheet->setCellValue('C1', 'SEMESTER');
$sheet->setCellValue('D1', 'TAHUN');
$sheet->setCellValue('E1', 'STATUS');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:E1')->applyFromArray($styleArray);
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

foreach (array('B', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_dosen)) {
    $code = $data['kode_akd'];
    $semester = $data['semester'];
    $tahun = $data['tahun'];
    $status = $data['is_active'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $code);
    $sheet->setCellValue("C" . $rowNumber, $semester);
    $sheet->setCellValue("D" . $rowNumber, $tahun);
    $sheet->setCellValue("E" . $rowNumber, $status);
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