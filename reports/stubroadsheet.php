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

<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../ajax/stusearch.js"></script>
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
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
                    <form name="filter" action="stubroadsheet.php" method="post">
                        <h3>Filter</h3>
                        
                        <table class="filtertable">
                            <tr>
                                <td>Dataset</td>
                                <td>    
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
                                </td>
                            </tr>
                        </table>

                        <a href="#" class="button" onclick="document.forms['filter'].submit(); return false;">
                            <span class="filter">Apply Filter</span>
                        </a>
                    </form>
                </div>

                <div id="content">
                    <h2>Student Broadsheet</h2>
                    <?php
                    if (isset($_POST['dataset'])) {
                        $datasetid = $_POST['dataset'];

                        $result = mysql_query("SELECT DISTINCT CONCAT(', GROUP_CONCAT(IF(shortname = \"',shortname,'\", grade,null)) AS `',shortname,'`') AS subjects FROM results_view WHERE datasetid = '$datasetid'");

                        $selectstr = "SELECT CONCAT(surname, \", \", forename) AS studentname";
                        while ($row = mysql_fetch_assoc($result)) {
                            $selectstr = $selectstr . $row['subjects'];
                        }
                        $selectstr = $selectstr . " FROM results_view WHERE datasetid = '$datasetid' GROUP BY studentname";
                        $result = mysql_query($selectstr);

                        $subjects = mysql_query("SELECT DISTINCT shortname FROM results_view where datasetid = '$datasetid' ORDER BY shortname");

                        echo "<table class=\"contenttable\">\n";
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