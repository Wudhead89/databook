<?php
/* 
    Document   : config.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/

// Specify the server and connection string attributes
$db_host = "localhost";
$db_name = "my_results";
$username = "root";
$password = "admin";

// Connect to the SQl server
$db_con = mysql_connect($db_host, $username, $password);
$connection_string = mysql_select_db($db_name);

?>