<!-- Developed By Hesham Alatrash
     Heshamoov90@Gmail.com -->
<?php

include('../config/dbConfig.php');

$id = $_REQUEST["id"];
$fromdate = $_REQUEST["fromdate"];
$todate = $_REQUEST["todate"];


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
            
        WHERE STR_TO_DATE(assignments.created_at,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate'
        AND employees.id = $id 
        ORDER BY date DESC";


// echo $sql;

$result = $conn->query($sql);

$rownumber = 1;
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
<button class='w3-button w3-indigo print-btn w3-hover-red' 
onclick = 'print_assignments_list()'>
<i style='font-size:24px' class='fa'>&#xf02f;</i>
</button>
                 </th>
            </tr>
            </thead>";

    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='w3-text-black'>
                <td>$rownumber</td>
                <td>
                $row[date]
                </td>
                <td align='left'>$row[course] - $row[section]</td>
                <td colspan=2 style='text-align: right;'>
<button class='w3-button w3-ripple w3-hover-green w3-round-xxlarge' data-toggle='modal' data-target='#assignment' onclick='content($row[assignment_id])'>
                $row[title] - $row[assignment_id]
                </button>
                </td>
                
        </tr>";
        $rownumber++;
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
