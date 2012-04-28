<?php
/*
  Document   : tchdatareport.php
  Created on : 12-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>  
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/gettchgroups.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="js/corefunctions.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Teaching Group Data Report</title>
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           

                <?php
                
                include('../mssql.php');
                
                // retrieve teacher details
                echo "Please select a teacher : ";
                $sqlstring = "SELECT LecturerId, Surname, Forename FROM lectdets WHERE setid = '" . $_SESSION['setid'] . "' AND NonTeaching = 'N' AND active = 'Y' ORDER BY Surname";
                $tchDetails = sqlsrv_query($conn, $sqlstring);

                echo "<select name=\"tch\" onchange=getTchGroups(this.value)>";
                while ($row = sqlsrv_fetch_array($tchDetails, SQLSRV_FETCH_ASSOC)) {
                    echo "<option value=\"" . $row['LecturerId'] . "\">" . $row['Surname'] . ", " . $row['Forename'] . "</option>";
                }                
                echo "</select>";
                
                sqlsrv_free_stmt($tchDetails);

                ?>

                <div id="selecttchgroup"></div>
                
                <div id="tchgroupdata"></div>
                
            </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>