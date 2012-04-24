<?php
/*
 * Document     : login.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : main login script
 * Params       : username, password
*/

// check if a user is already logged in if so return
session_start();
if (isset($_SESSION['name'])) {
    echo $_SESSION['name'] . " <a href=\"logout.php\">[logout]</a>";
    return;
}

// get database connection
include('config.php');

// if the parameters are set begin authenication
if (isset($_GET['username']) && isset($_GET['password'])) {

    $username = $_GET['username'];
    $password = $_GET['password'];

    // create sql string and get results
    $getUser_sql = 'SELECT * FROM users WHERE username="' . $username . '" AND password = "' . $password . '"';
    $getUser = mysql_query($getUser_sql);
    $getUser_result = mysql_fetch_assoc($getUser);
    $getUser_RecordCount = mysql_num_rows($getUser);

    // if sql doesn't return any results then the authenication must have failed
    if ($getUser_RecordCount < 1) {
        echo '0'; // return a '0' if the user doesn't authenicate against the database
    } else {
        // update database table to track the login
        $iduser = $getUser_result['idusers'];
        $insertsql = 'INSERT INTO login (userid, date) VALUES ("' . $iduser . '", NOW() )';
        mysql_query($insertsql);

        // add user to the session
        $_SESSION['username'] = $getUser_result['username'];
        $_SESSION['name'] = $getUser_result['firstname'] . " " . $getUser_result['lastname'];
        $_SESSION['type'] = $getUser_result['type'];
        $_SESSION['setid'] = '2011/2012'; 

        echo '1'; // return a '1' if the user does authenicate against the database
    }
}
?>