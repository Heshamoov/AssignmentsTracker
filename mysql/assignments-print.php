<?php
include('../config/dbConfig.php');
include_once('../lib/fpdf/fpdf.php');
session_start();

if (isset($_POST['assignment'])) {
    $from = $_POST['from'];
    $_SESSION['from'] = $from;
    $to = $_POST['to'];
    $_SESSION['to'] = $to;
    $emp = $_POST['empid'];
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
        $this->Cell(0, 0, 'ASSIGNMENT TRACKER REPORT',   0, 2, 'C');
        $this->SetLineWidth(0.2);
        $this->Line(10, 52, 200, 52);
        $this->SetFont('times', 'B', 10);
        $this->Ln(15);
        $this->Cell(0, 0, 'Assignments From: '. $_SESSION['from'] .' - To: ' .$_SESSION['to'], 0, 1, 'C');
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
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFillColor(230,230,230);



$sql = "SELECT employees.first_name 'employee', employee_positions.name 'position', 
        employee_departments.name 'dept', subjects.name 'subject',
        assignments.title 'title', assignments.employee_id id,
        CONVERT(assignments.created_at, Date) 'date', courses.course_name 'course', batches.name 'section',
        assignments.id 'assignment_id'
        
        FROM employee_departments
            INNER JOIN employees ON employee_departments.id = employees.employee_department_id
            INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id
            INNER JOIN assignments ON employees.id = assignments.employee_id
            INNER JOIN subjects ON assignments.subject_id = subjects.id
            INNER JOIN batches ON subjects.batch_id = batches.id
            INNER JOIN courses ON batches.course_id = courses.id
            
        WHERE STR_TO_DATE(assignments.created_at,'%Y-%m-%d') BETWEEN '$from' AND '$to'
        AND employees.id = $emp 
        ORDER BY date DESC";


$result = $conn->query($sql);

$rownumber = 1;
if ($result->num_rows > 0) {
    $pdf->MultiCell(10, 8, "#", 1, 'C', 1);
    $pdf->SetXY($x + 10, $y);
    $pdf->MultiCell(25, 8, "Date", 1, 'C', 1);
    $pdf->SetXY($x + 35, $y);
    $pdf->MultiCell(35, 8, "Grade", 1, 'C', 1);
    $pdf->SetXY($x + 70, $y);
    $pdf->MultiCell(0, 8, "Title", 1, 'C', 1);

    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 8, $rownumber, 1, '', 'L');
        $pdf->Cell(25, 8,  $row['date'], 1, '', 'L');
        $pdf->Cell(35, 8,  $row['course'] .'-'. $row['section'], 1, '', 'L');
        $pdf->Cell(0, 8,   $row['title'] , 1, '1', 'L');
        $rownumber++;
    }
} else {
    $pdf->Cell(10, 8, 'No Data Found! Try another search.', 1, '', 'L');
}
$conn->close();





//$pdf->Output('D', 'assignment-teachers.pdf', true);
$pdf->Output('I', 'assignment-teachers.pdf', true);
$pdf->Close();

