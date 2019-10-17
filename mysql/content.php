<?php

include ('../config/dbConfig.php');

$id = $_REQUEST["id"];

$sql = "SELECT content
        FROM assignments
        WHERE id = $id";

// echo $sql;
    
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['content'];
        }
} else {
    echo "No Data Found! Try another search.";
}
$conn->close();