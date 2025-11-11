<?php
session_start();
require_once "database.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Fetch data
$query = "SELECT users.full_name, classes.class_name, classes.study_programme FROM enrollments JOIN users ON enrollments.user_id = users.id JOIN classes ON enrollments.class_id = classes.class_id;";
$result = $conn->query($query);

// Check for export action
if (isset($_POST['export'])) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the header
    $sheet->setCellValue('A1', 'Full Name');
    $sheet->setCellValue('B1', 'Class Name');
    $sheet->setCellValue('C1', 'Study Programme');

    $headerStyleArray = [
        'font' => [
            'bold' => true,
            'size' => 12,
            'color' => ['argb' => 'FFFFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => '1F4E78'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];

    $sheet->getStyle('A1:C1')->applyFromArray($headerStyleArray);

    $row = 2; // Starting row after the headers

    // Output data of each row
    while($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['full_name']);
        $sheet->setCellValue('B' . $row, $data['class_name']);
        $sheet->setCellValue('C' . $row, $data['study_programme']);
        $row++;
    }

    // Set style for body of the sheet
    $bodyStyleArray = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_LEFT,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A2:C' . ($row - 1))->applyFromArray($bodyStyleArray);

    $writer = new Xlsx($spreadsheet);
    $filename = 'class-enrollment-list.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
    $writer->save('php://output');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
    <title>Student Enrollment Details</title>
    <style>
        .container { max-width: 1200px; }
        th, td { text-align: center; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Student Enrollment Details</h1>
        <form method="post">
            <button type="submit" name="export" class="btn btn-primary mb-3">Export to Excel</button>
        </form>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Full Name</th>
                    <th>Class Name</th>
                    <th>Study Programme</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['class_name']) ?></td>
                    <td><?= htmlspecialchars($row['study_programme']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
