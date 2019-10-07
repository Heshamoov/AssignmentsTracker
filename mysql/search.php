<?php

include ('../config/dbConfig.php');

$sql = "SELECT employees.first_name 'employee', employee_positions.name 'position', 
        employee_departments.name 'dept', subjects.name 'subject',
        assignments.title 'title', count(assignments.title) count, assignments.employee_id id
        FROM ((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id)
        
        GROUP BY assignments.employee_id
        ORDER BY `dept`, `count` DESC";

//echo $sql;
    
$result = $conn->query($sql);

$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<tr class='w3-blue'>
            <th>Employee</th>
            <th>Title</th>
            <th>Count</th>
        </tr>";
    
    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        
        if ($row['dept'] !== $First_line) {
            echo "<tr class='w3-green'>";
            $First_line = $row['dept'];
        }
        else {
            echo "<tr>";
        }
        echo "<td> $row[employee] </td>
              <td> $row[position] </td>
              <td><a data-toggle='popover' id='popoverA'  onmouseenter='getTask($row[id])'> $row[count]</a></td>
            </tr>";
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
