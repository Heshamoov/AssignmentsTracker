<!-- Developed By Hesham Alatrash
     Heshamoov90@Gmail.com -->
<?php

include ('../config/dbConfig.php');

$from_date = $_REQUEST["from_date"];
$to_date = $_REQUEST["to_date"];

$search = "SELECT employees.first_name 'employee', employee_positions.name 'position', employees.id 'employee_id',
        employee_departments.name 'dept', subjects.name 'subject',
        assignments.title 'title', count(assignments.title) count, assignments.employee_id 'assignment_id',
        CONVERT(assignments.created_at, Date) 'date'
        FROM ((((
            employee_departments
                INNER JOIN employees ON employee_departments.id = employees.employee_department_id)
                    INNER JOIN employee_positions ON employees.employee_position_id = employee_positions.id)
                        INNER JOIN assignments ON employees.id = assignments.employee_id)
                            INNER JOIN subjects ON assignments.subject_id = subjects.id) 
        WHERE STR_TO_DATE(assignments.created_at,'%Y-%m-%d')
                BETWEEN
                '$from_date' AND '$to_date'
        GROUP BY assignments.employee_id
        ORDER BY `dept`, `count` DESC";


// echo $search;

$searchResult = $conn->query($search);

if ($searchResult->num_rows > 0) {
    $First_line = "";
    while ($row = $searchResult->fetch_assoc()) {
        if ($row['dept'] !== $First_line) {
            echo "<thead>
                    <tr class='w3-indigo'>
                        <th class='w3-center w3-large'>$row[dept]</th>
                    </tr>
                   </thead>";
            echo "<tr class='w3-text-green w3-white'>";
            $First_line = $row['dept'];
        } else {
            echo "<tr>";
        }
        echo "<td class='w3-center'>
                    <button class='w3-button w3-ripple w3-hover-green' data-toggle='popover' data-trigger='focus'
                    onclick='assignments($row[employee_id])'>$row[employee] - $row[count]</button>
              </td>
            </tr>";
    }
} else {
    echo "<tr><th>No Data Found! Try another search.</th></tr>";
}
$conn->close();




 