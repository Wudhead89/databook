<?php
/*
  Document   : editselectedstudent.php
  Created on : 29-Feb-2012
  Author     : Richard Williamson
 */
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}

$studentid = $_GET['studentid'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../ajax/stusearch.js" language="javascript" type="text/javascript"></script>       
        <script src="ajax/getforms.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Edit Student</title>
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">

        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">

                <div id="filter">
                    <?php include('adminmenu.php'); ?>
                </div>
                
                <div id="content">
                    <?php echo $studentid; ?>
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>