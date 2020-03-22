<?php

include('config/dbConfig.php');
session_start();

    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_salt']) && !isset($_POST['token'])) {
        $sql = "SELECT * FROM users WHERE id = '$_COOKIE[user_id]' AND salt = '$_COOKIE[user_salt]' AND 
        (id = '4818'or id = '5077' or id = '2667' or id = '5112' or id = '3007')";
        //   echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) { //Successful login
            $_SESSION['login'] = 1;
            setcookie("user_id", "",time() - 3600,"/",".lvh.me");
            setcookie("user_salt", "",time() - 3600,"/",".lvh.me");
            header('Location: tracker.php');
        } else {
            $_SESSION['noaccess'] = 1;
            header('Location: index.php');
        }
    } else {
        if (isset($_POST['token'])) {
            $sql = "select * from users where username = '$_POST[user]' and 
            (id = '4818'or id = '5077' or id = '2667' or id = '5112' or id = '3007')";
            //   echo $sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION['login'] = 1;
                header('Location: tracker.php');
            } else {
                $_SESSION['noaccess'] = 1;
                header('Location: index.php');
            }
        }
    }



