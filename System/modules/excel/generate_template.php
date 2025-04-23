<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $input = json_decode(file_get_contents("php://input"), true);
    $headers = $input['headers'] ?? [];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $colIndex = 1;
    foreach ($headers as $header) {
        $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
        $sheet->setCellValue($cell, $header);
        $colIndex++;
    }

    $lastCol = Coordinate::stringFromColumnIndex(count($headers));
    $headerRange = "A1:{$lastCol}1";

    $sheet->getStyle($headerRange)->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 12,
            'name' => 'Tahoma',
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F2F2F2'],
        ],
    ]);

    $dataRange = "A2:{$lastCol}100";
    $sheet->getStyle($dataRange)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ]);

    for ($i = 1; $i <= count($headers); $i++) {
        $colLetter = Coordinate::stringFromColumnIndex($i);
        $sheet->getColumnDimension($colLetter)->setWidth(40);
    }

    $sheet->freezePane('A2');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="employee_data_template.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request method."
    ]);
}