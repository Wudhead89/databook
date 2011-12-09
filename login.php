<?php
/*
    Document   : login.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/
    
include('config.php');

session_start();

// if a user is already logged in return
if (isset($_SESSION['name'])) {
    echo $_SESSION['name'] . " <a href=\"logout.php\">[logout]</a>";
    return;
}

if (isset($_GET['username']) && isset($_GET['password'])) {

    $username = $_GET['username'];
    $password = $_GET['password'];

    $getUser_sql = 'SELECT * FROM users WHERE username="' . $username . '" AND password = "' . $password . '"';
    $getUser = mysql_query($getUser_sql);
    $getUser_result = mysql_fetch_assoc($getUser);
    $getUser_RecordCount = mysql_num_rows($getUser);

    if ($getUser_RecordCount < 1) {
        echo '0';
    } else {
        // update database table
        $iduser = $getUser_result['idusers'];
        $insertsql = 'INSERT INTO login (userid, date) VALUES ("' . $iduser . '", NOW() )';
        
        mysql_query($insertsql);

        // add user to the session
        $_SESSION['username'] = $getUser_result['username'];
        $_SESSION['name'] = $getUser_result['firstname'] . " " . $getUser_result['lastname'];
        
        // add setid to the session
        $_SESSION['setid'] = '2011/2012'; 

        // return to ajax_framework.js
        echo $_SESSION['name'] . " <a href=\"logout.php\">[logout]</a>";
    }
}
?>