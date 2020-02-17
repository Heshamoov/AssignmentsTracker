<?php
include('../config/dbConfig.php');
include_once('../lib/fpdf/fpdf.php');
session_start();
date_default_timezone_set('Asia/Dubai');

if (isset($_POST['print-teachers-btn'])) {
    $from = $_POST['date-from'];
    $_SESSION['from'] = $from;
    $to = $_POST['date-to'];
    $_SESSION['to'] = $to;

}

class PDF extends FPDF
{
// Page header
    public function Header()
    {
        // Logo
        $this->Image('../assets/img/Alsanawbar-Logo.jpg', 95, 10, 20, 20);
        $this->SetFont('times', 'B', 13);
        // Move to the right
        $this->Ln(25);
        // Title
        $this->Cell(0, 0, 'Al SANAWBAR SCHOOL', 0, 0, 'C');
        $this->SetFont('times', 'B', 10);
        $this->Ln(7);
        $this->Cell(0, 0, 'Al AIN - U.A.E', 0, 2, 'C');
        $this->Ln(5);
        $this->Cell(0, 0, 'ASSIGNMENT TRACKER REPORT', 0, 2, 'C');
        $this->SetLineWidth(0.2);
        $this->Line(10, 52, 200, 52);
        $this->SetFont('times', 'B', 10);
        $this->Ln(15);
        $this->Cell(0, 0, 'Assignments From: ' . $_SESSION['from'] . ' - To: ' . $_SESSION['to'], 0, 1, 'C');
        $this->Ln(10);
    }

// Page footer
    public function Footer()
    {
        $date = date("d-m-Y - h:m:s");
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // times italic 8
        $this->SetFont('times', 'I', 8);
        // Page number

        $this->Cell(10, 10, 'Printed By ' . $_SESSION['name'], 0, 0, 'L');
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Printed on ' . $date, 0, 0, 'R');

    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('times', '', 10);
$pdf->SetFillColor(230, 230, 230);

$search = "SELECT employees.first_name 'employee', employee_positions.name 'position', 
        employee_departments.name 'dept', subjects.name 'subject',
        assignments.title 'title', count(assignments.title) count, assignments.employee_id id,
        CONVERT(assignments.created_at, Date) 'date'
        FROM ((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id) 
        WHERE STR_TO_DATE(assignments.created_at,'%Y-%m-%d')
                BETWEEN
                '$from' AND '$to'
        GROUP BY assignments.employee_id
        ORDER BY `dept`, `count` DESC";


// echo $search;

$searchResult = $conn->query($search);

if ($searchResult->num_rows > 0) {
    $First_line = "";
    while ($row = $searchResult->fetch_assoc()) {
        if ($row['dept'] !== $First_line) {
            $pdf->SetFont('times', 'B', 12);
            $pdf->MultiCell(0, 8, $row['dept'], 1, 'C', 1);
            $pdf->SetFont('times', '', 10);
            $First_line = $row['dept'];
        }

        $pdf->Cell(0, 8, $row['employee'], 1, '', 'L');
        $pdf->Cell(0, 8, $row['count'] . "  ", 1, '1', 'R');
    }

} else {
    $pdf->Cell(0, 8, "No Assignments", 1, '1', 'L');

}
$conn->close();

//$pdf->Output('D', 'assignment-teachers.pdf', true);
$pdf->Output('I', 'assignment-teachers.pdf', true);
$pdf->Close();

