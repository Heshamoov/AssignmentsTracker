<!-- Developed By Hesham Alatrash
     Heshamoov90@Gmail.com -->
<?php

include('../config/dbConfig.php');

$employee_id = $_REQUEST["employee_id"];
$from_date = $_REQUEST["from_date"];
$to_date = $_REQUEST["to_date"];


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
            
        WHERE STR_TO_DATE(assignments.created_at,'%Y-%m-%d') BETWEEN '$from_date' AND '$to_date'
        AND employees.id = $employee_id 
        ORDER BY date DESC";

// echo $sql;

$result = $conn->query($sql);

$row_number = 1;
if ($result->num_rows > 0) {
    echo "<thead>
            <tr class='w3-indigo'>
                <th>#</th>
                <th>Date</th>
                <th>Grade</th>
                <th style='text-align: center'>
                    Title
                </th>
                <th>
<form target='_blank' action='mysql/assignments-print.php' method='post'>                
                <input hidden name='from_date' value='$from_date'>                
                <input hidden name='to_date' value='$to_date'>
                <input hidden name='employee_id' value='$employee_id'>
                
<button  type='submit' name='print-assignments-list' class='w3-button w3-indigo print-btn w3-hover-red'>
<i style='font-size:24px' class='fa'>&#xf02f;</i>
</button>
</form>
                 </th>
            </tr>
            </thead>";

    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='w3-text-black'>
                <td>$row_number</td>
                <td>
                $row[date]
                </td>
                <td align='left'>$row[course] - $row[section]</td>
                <td colspan=2 style='text-align: right;'>
<button type='submit' name='print-assignment' class='w3-button w3-ripple w3-hover-green w3-round-xxlarge' data-toggle='modal' data-target='#assignment' onclick='content($row[assignment_id])'>
                $row[title]
                </button>
                </td>
                
        </tr>";
        $row_number++;
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
