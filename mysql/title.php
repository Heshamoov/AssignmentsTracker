<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT employees.first_name 'name', subjects.name 'subject', assignments.title 'title', CONVERT(assignments.created_at, Date) 'date',
                courses.course_name grade, batches.name section
        FROM ((((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id)
                                INNER JOIN batches ON subjects.batch_id = batches.id)
                                    INNER JOIN courses ON batches.course_id = courses.id)
        
        WHERE assignments.id = $id";

// echo $sql;
    
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<thead>
        		<tr>
        			<th>$row[name]</th>
        			<th>$row[grade]-$row[section]</th>
        			<th>$row[subject]</th>
    			</tr>
    			<tr>
    			<th colspan=3 style='text-align: center; font-size: 18px'>$row[title] - $row[date]</th>
    			</tr>";
        }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();