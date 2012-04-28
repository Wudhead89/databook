<?php
/*
  Document   : tchGroupBroadsheet.php
  Created on : 22-May-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
include('../config.php');
include('functions.php');
include('buildsqlstring.php');

if (isset($_POST['sen'])) {
    $sen = $_POST['sen'];
} else {
    $sen = array();
}

if (isset($_POST['dataset'])) {
    $datasetid = $_POST['dataset'];
} else if (isset($_GET['datasetid'])) {
    $datasetid = $_GET['datasetid'];
}
$subjectid = $_GET['subjectid'];
?> 
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/corefunctions.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Teaching Group Broadsheet</title>        
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">       
                <div id="filter">
                <form name="filter" action="tchgroupbroadsheet.php?datasetid=$datasetid&amp;subjectid=$subjectid" method="post">
                <?php include('filter.php'); ?>
                </form>
                </div>  <!-- end filter -->
                <div id="content">
                    
                <?php

                if (isset($datasetid)) {
                    $subjectname = getSubjectName($subjectid);

                    $sqlstring = "SELECT tchgroups.tchgroupcode,
                        SUM(IF(grades.grade='A*',1,0)) as 'A*',
                        SUM(IF(grades.grade='A',1,0)) as A,
                        SUM(IF(grades.grade='B',1,0)) as B,
                        SUM(IF(grades.grade='C',1,0)) as C,
                        SUM(IF(grades.grade='D',1,0)) as D,
                        SUM(IF(grades.grade='E',1,0)) as E,
                        SUM(IF(grades.grade='F',1,0)) as F,
                        SUM(IF(grades.grade='G',1,0)) as G,
                        SUM(IF(grades.grade='U',1,0)) as U
                        FROM results 
                        INNER JOIN grades ON results.gradeid = grades.gradeid 
                        INNER JOIN students ON results.studentid = students.studentid
                        INNER JOIN tchgroups ON results.studentid = tchgroups.studentid AND results.subjectid = tchgroups.subjectid";
                    $sqlstring .= buildSQLStringIncDataSet($datasetid);
                    $sqlstring .= " AND results.subjectid = " . $subjectid;
                    $sqlstring .= " GROUP BY tchgroups.tchgroupcode";

                    $result = mysql_query($sqlstring);

                    echo "<h2>Teaching Group Broadsheet: $subjectname</h2>";
                    
                    echo "<table class=\"contenttable\">
                        <thead>
                        <tr>
                        <th>Teaching Group</th>
                        <th>A*</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>	
                        <th>E</th>
                        <th>F</th>
                        <th>G</th>
                        <th>U</th>
                        <th>Total</th>
                        <th>%AA</th>
                        <th>%AC</th>
                        <th>%AG</th>
                        </tr>
                        </thead>";

                    echo "</tbody>";
                    while ($row = mysql_fetch_assoc($result)) {
                        $total = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'] + $row['U'];
                        $aa = $row['A*'] + $row['A'];
                        $ac = $row['A*'] + $row['A'] + $row['B'] + $row['C'];
                        $ag = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'];

                        echo "<tr>\n";
                        echo "<th><a href=\"tchgroup.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['tchgroupcode'] . "</a></th>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=1&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['A*'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=2&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['A'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=3&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['B'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=4&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['C'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=5&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['D'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=6&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['E'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=7&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['F'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=8&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['G'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=9&amp;tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['U'] . "</a></td>";
                        echo "<td>" . $total . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($aa / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($ac / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($ag / $total) * 100)) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

        <?php include('../footer.php'); ?>

    </div> <!-- end of container -->
</body>
</html>