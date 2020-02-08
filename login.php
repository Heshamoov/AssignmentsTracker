<?php

include('config/dbConfig.php');
session_start();

if ($_POST['token'] != '') {

    $sql = "select users.id user,users.first_name name from users where users.username = '$_POST[user]';";
//    echo $sql;
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $user = $row['user'];
        $_SESSION['name'] = $row['name'];
    }

    $sql = "select * from users where username = '$_POST[user]' and 
    (id = '4818'or id = '5077' or id = '2667' or id = '3049' or id = '5112')";
   echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['login'] = 1;
        header('Location: tracker.php');
    } else {
        $_SESSION['noaccess'] = 1;
        header('Location: index.php');
    }
}