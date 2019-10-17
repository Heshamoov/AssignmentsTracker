<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT assignments.title 'title', CONVERT(assignments.created_at, Date) 'date'
        FROM ((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id)
        
        WHERE employees.id = $id";

// echo $sql;
        echo $id;
    
$result = $conn->query($sql);

$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<table><th>Title</th><th>Date</th>";
    
    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td> $row[title]</td><td>$row[date]</td></tr>";
    }
    echo "</table>";
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
