<?php
/*
    Document   : stuBroadsheet.php
    Created on : 05-May-2011
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
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Student Broadsheet</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container"> 
                

                <?php
                include('../config.php');

                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];
                } else if (isset($_GET['datasetid'])) {
                    $datasetid = $_GET['datasetid'];
                }
                ?>

                <div id="filter">
                Dataset: &nbsp;
                <form name="filter" action="stuBroadsheet.php" method="post">
                    <select name="dataset">

                    <?php
                    $datasets = mysql_query("SELECT * FROM datasets");
                    while ($ds = mysql_fetch_assoc($datasets)) {
                        echo "<option value=\"" . $ds['datasetid'] . "\"";

                        if (isset($datasetid) && $datasetid == $ds['datasetid']) {
                            echo " selected ";
                        }

                        echo ">" . $ds['datasetname'] . "</option>";
                    }
                    ?>

                    </select>
                    <input type="submit" value="submit" /><br />
                </form>
                </div>
                
                <div id="content">
                <h2>Student Broadsheet</h2>
                <?php
                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];

                    $result = mysql_query("SELECT DISTINCT CONCAT(', GROUP_CONCAT(IF(shortname = \"',shortname,'\", grade,null)) AS `',shortname,'`') AS subjects FROM results_view WHERE datasetid = '$datasetid'");

                    $selectstr = "SELECT studentname";
                    while ($row = mysql_fetch_assoc($result)) {
                        $selectstr = $selectstr . $row['subjects'];
                    }
                    $selectstr = $selectstr . " FROM results_view GROUP BY studentname";
                    $result = mysql_query($selectstr);

                    $subjects = mysql_query("SELECT DISTINCT shortname FROM results_view WHERE datasetid = '$datasetid' ORDER BY shortname");

                    echo "<table>\n";
                    echo "<tr>\n";
                    echo "<td>Student Name</td>\n";

                    while ($subject = mysql_fetch_assoc($subjects)) {
                        echo "<td>" . $subject['shortname'] . "</td>\n";
                    }
                    echo "</tr>\n";

                    while ($row = mysql_fetch_assoc($result)) {
                        echo "<tr>\n";
                        echo "<td>" . $row['studentname'] . "</td>\n";
                        mysql_data_seek($subjects, 0);
                        while ($subject = mysql_fetch_assoc($subjects)) {
                            echo "<td>" . $row[$subject['shortname']] . "</td>\n";
                        }
                        echo "</tr>\n";
                    }

                    echo "</table>";
                }
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>