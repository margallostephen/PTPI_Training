<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require '../../vendor/autoload.php';

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input || !is_array($input)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data'
        ]);
        exit;
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = array_keys($input[0] ?? []);

    $formattedHeaders = array_map(function ($header) {
        return ucwords(str_replace('_', ' ', $header));
    }, $headers);

    $sheet->fromArray($formattedHeaders, null, 'A1');

    $row = 2;
    foreach ($input as $record) {
        $sheet->fromArray(array_values($record), null, 'A' . $row++);
    }

    $highestColumn = $sheet->getHighestColumn();
    $highestRow = $sheet->getHighestRow();
    $dataRange = 'A2:' . $highestColumn . $highestRow;

    $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 12, 'name' => 'Tahoma'],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN]
        ],
    ]);

    $sheet->getStyle($dataRange)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true
        ]
    ]);

    foreach (range('A', $highestColumn) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    for ($i = 1; $i <= $highestRow; $i++) {
        $sheet->getRowDimension($i)->setRowHeight(-1);
    }

    $filename = 'employee_data_' . date('Y-m-d_H-i-s') . '.xlsx';
    $filepath = __DIR__ . '/../../exports/' . $filename;
    (new Xlsx($spreadsheet))->save($filepath);

    echo json_encode([
        'success' => true,
        'file' => '/System/exports/' . $filename
    ]);

} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request method."
    ]);
}

?>