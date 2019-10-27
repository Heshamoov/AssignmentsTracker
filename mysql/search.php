<!-- Developed By Hesham Alatrash
     Heshamoov90@Gmail.com -->
<?php

include ('../config/dbConfig.php');

$fromdate = $_REQUEST["fromdate"];
$todate = $_REQUEST["todate"];

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
                '$fromdate' AND '$todate'
        GROUP BY assignments.employee_id
        ORDER BY `dept`, `count` DESC";


// echo $search;

$searchResult = $conn->query($search);

$rownumber = 1;
if ($searchResult->num_rows > 0) {
    $First_line = "";
    while ($row = $searchResult->fetch_assoc()) {
        if ($row['dept'] !== $First_line) {
            echo "<thead><tr class='w3-light-grey'>
                    <th colspan=2 class='w3-center'>$row[dept]</th>
                </tr></thead>";
            echo "<tr class=' w3-text-green w3-hover-green w3-white'>";
            $First_line = $row['dept'];
        } else {
            echo "<tr class='w3-hover-green'>";
        }

        echo "<td> $row[employee] </td>
              <td><button class='w3-button w3-ripple w3-hover-white w3-round-xxlarge' data-toggle='popover'
                data-trigger='focus'
                onclick='assignments($row[id])'>$row[count]</button>
              </td>
            </tr>";
    }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();




 