<?php
/*
  Document   : tchdatareport.php
  Created on : 12-Dec-2011
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
        <script src="../ajax/stusearch.js" language="javascript"></script>
        <script src="../ajax/gettchgroups.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Teaching Group Data Report</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           

                <?php
                
                include('../mssql.php');
                
                // retrieve teacher details
                echo "Please select a teacher : ";
                $sqlstring = "SELECT LecturerId, Surname, Forename FROM lectdets WHERE setid = '" . $_SESSION['setid'] . "' AND NonTeaching = 'N' AND active = 'Y' ORDER BY Surname";
                $tchDetails = sqlsrv_query($conn, $sqlstring);

                echo "<select name=\"tch\" onchange=getTchGroups(this.value)>\n";
                while ($row = sqlsrv_fetch_array($tchDetails, SQLSRV_FETCH_ASSOC)) {
                    echo "<option value=\"" . $row['LecturerId'] . "\">" . $row['Surname'] . ", " . $row['Forename'] . "</option>\n";
                }                
                echo "</select>\n";
                
                sqlsrv_free_stmt($tchDetails);

                ?>

                <div id="selecttchgroup"></div>
                
                <div id="tchgroupdata"></div>
                
            </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>