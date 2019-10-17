<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT assignments.id id, assignments.title 'title', assignments.created_at
        FROM ((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id)
        
        WHERE employees.id = $id";

// echo $sql;
    
$result = $conn->query($sql);

$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<thead><tr><th>Title</th><th>Date</th></tr></thead>";
    
    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>
<button class='w3-button' data-toggle='modal' data-target='#assignment' title='Popover' onclick='content($row[id])'>$row[title]</button>
                </td>
                <td>$row[created_at]</td>
              </tr>";
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
