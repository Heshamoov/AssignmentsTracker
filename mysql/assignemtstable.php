<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT assignments.id id, assignments.title 'title', CONVERT(assignments.created_at, Date) 'date'
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
    echo "<thead class='w3-black'><tr class='w3-text-black'><th>Title</th><th>Date</th></tr></thead>";
    
    $First_line = "";
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='w3-text-black'>
                <td>
                $row[date]
                </td>
                <td>
                 <button class='w3-button w3-ripple w3-hover-green w3-round-xxlarge' data-toggle='modal' data-target='#assignment' onclick='content($row[id])'>
                $row[title]
                </button>
                </td>
        </tr>";
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();
