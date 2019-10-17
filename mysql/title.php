<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT title
        FROM assignments
        WHERE id = $id";

// echo $sql;
    
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['title'];
        }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();