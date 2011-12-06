<?php
/*
    Document   : mssql.php
    Created on : 05-Dec-2011
    Author     : Richard Williamson
*/


// Specify the server and connection string attributes
$serverName = "Xena";
$connectionInfo = array( "UID"=>"STUD_ADMIN", "PWD"=>"STUD_ADMIN", "Database"=>"Stud_Administration");

// Connect to the SQl server
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}

//$tsql = "SELECT Studentid, Name, CourseYear FROM students where setid = '2011/2012'"; 
//$getStudents = sqlsrv_query( $conn, $tsql ); 

//while( $row = sqlsrv_fetch_array( $getStudents, SQLSRV_FETCH_ASSOC ) )  
//{  
//  echo $row['Name']  . "</br>";  
//} 

//sqlsrv_free_stmt( $getStudents ); 
//sqlsrv_close( $conn ); 

?>