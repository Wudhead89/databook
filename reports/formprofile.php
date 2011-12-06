<?php
/*
    Document   : formprofile.php
    Created on : 05-Dec-2011
    Author     : Richard Williamson
*/
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../ajax/javascript.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Form Profile</title>        
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  

                <?php
                include('../config.php');
                include('functions.php');                

                echo "<h2>Form Profile</h2>";
                echo "";
                
                
                ?>

            </div> <!-- end content-container -->

        <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>