<?php
/*
  Document   : subBroadsheet.php
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

include('../config.php');
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

if (isset($_POST['compset'])) {
    $compsetid = $_POST['compset'];
} else if (isset($_GET['compsetid'])) {
    $compsetid = $_GET['compsetid'];
}

if (isset($_POST['compset']) && $_POST['compset'] != "") {
    $compsetid = $_POST['compset'];

    $sqlstring = "SELECT subjects.subjectname, results.subjectid, 
                        SUM(IF(grades.grade='A*',1,0)) as 'A*',
                        MAX(IF(grades.grade='A*',results.gradeid,0)) as sgradeid,
                        SUM(IF(grades.grade='A',1,0)) as A,
                        MAX(IF(grades.grade='A',results.gradeid,0)) as agradeid,
                        SUM(IF(grades.grade='B',1,0)) as B,
                        MAX(IF(grades.grade='B',results.gradeid,0)) as bgradeid,
                        SUM(IF(grades.grade='C',1,0)) as C,
                        MAX(IF(grades.grade='C',results.gradeid,0)) as cgradeid,
                        SUM(IF(grades.grade='D',1,0)) as D,
                        MAX(IF(grades.grade='D',results.gradeid,0)) as dgradeid,
                        SUM(IF(grades.grade='E',1,0)) as E,
                        MAX(IF(grades.grade='E',results.gradeid,0)) as egradeid,
                        SUM(IF(grades.grade='F',1,0)) as F,
                        MAX(IF(grades.grade='F',results.gradeid,0)) as fgradeid,
                        SUM(IF(grades.grade='G',1,0)) as G,
                        MAX(IF(grades.grade='G',results.gradeid,0)) as ggradeid,
                        SUM(IF(grades.grade='U',1,0)) as U,
                        MAX(IF(grades.grade='U',results.gradeid,0)) as ugradeid
                        FROM results 
                        INNER JOIN grades ON results.gradeid = grades.gradeid 
                        INNER JOIN subjects ON results.subjectid = subjects.subjectid
                        INNER JOIN students ON results.studentid = students.studentid";

    $sqlstring .= buildSQLStringIncDataSet($compsetid);
    $sqlstring .= " GROUP BY subjects.subjectname";

    $result = mysql_query($sqlstring);

    $compResults = array();

    $subjectResults = array(
        "subjectname" => 0,
        "total" => 0,
        "aa" => 0,
        "ac" => 0,
        "ag" => 0,
    );

    $i = 0;
    while ($row = mysql_fetch_assoc($result)) {

        $subjectResults['subjectname'] = $row['subjectname'];
        $subjectResults['total'] = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'] + $row['U'];
        $subjectResults['aa'] = $row['A*'] + $row['A'];
        $subjectResults['ac'] = $row['A*'] + $row['A'] + $row['B'] + $row['C'];
        $subjectResults['ag'] = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'];

        $compResults[$i] = $subjectResults;
        $i++;
    }
}
?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../ajax/stusearch.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Subject Broadsheet</title>        
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">       

                <?php
                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"subbroadsheet.php\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>Subject Broadsheet</h2>\n";

                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];

                    $sqlstring = "SELECT subjects.subjectname, results.subjectid, 
                            SUM(IF(grades.grade='A*',1,0)) as 'A*',
                            MAX(IF(grades.grade='A*',results.gradeid,0)) as sgradeid,
                            SUM(IF(grades.grade='A',1,0)) as A,
                            MAX(IF(grades.grade='A',results.gradeid,0)) as agradeid,
                            SUM(IF(grades.grade='B',1,0)) as B,
                            MAX(IF(grades.grade='B',results.gradeid,0)) as bgradeid,
                            SUM(IF(grades.grade='C',1,0)) as C,
                            MAX(IF(grades.grade='C',results.gradeid,0)) as cgradeid,
                            SUM(IF(grades.grade='D',1,0)) as D,
                            MAX(IF(grades.grade='D',results.gradeid,0)) as dgradeid,
                            SUM(IF(grades.grade='E',1,0)) as E,
                            MAX(IF(grades.grade='E',results.gradeid,0)) as egradeid,
                            SUM(IF(grades.grade='F',1,0)) as F,
                            MAX(IF(grades.grade='F',results.gradeid,0)) as fgradeid,
                            SUM(IF(grades.grade='G',1,0)) as G,
                            MAX(IF(grades.grade='G',results.gradeid,0)) as ggradeid,
                            SUM(IF(grades.grade='U',1,0)) as U,
                            MAX(IF(grades.grade='U',results.gradeid,0)) as ugradeid
                            FROM results 
                            INNER JOIN grades ON results.gradeid = grades.gradeid 
                            INNER JOIN subjects ON results.subjectid = subjects.subjectid
                            INNER JOIN students ON results.studentid = students.studentid";

                    $sqlstring .= buildSQLStringIncDataSet($datasetid);
                    $sqlstring .= " GROUP BY subjects.subjectname";

                    $result = mysql_query($sqlstring);

                    echo "<table class=\"contenttable\">
                            <tr>
                            <td>Subject Name</td>
                            <td class=\"gradecell\">A*</td>
                            <td class=\"gradecell\">A</td>
                            <td class=\"gradecell\">B</td>
                            <td class=\"gradecell\">C</td>
                            <td class=\"gradecell\">D</td>	
                            <td class=\"gradecell\">E</td>
                            <td class=\"gradecell\">F</td>
                            <td class=\"gradecell\">G</td>
                            <td class=\"gradecell\">U</td>
                            <td>Total</td>
                            <td>%AA</td>
                            <td>%AC</td>
                            <td>%AG</td>
                            </tr>";

                    while ($row = mysql_fetch_assoc($result)) {
                        $total = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'] + $row['U'];
                        $aa = $row['A*'] + $row['A'];
                        $ac = $row['A*'] + $row['A'] + $row['B'] + $row['C'];
                        $ag = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'];

                        echo "<tr>\n";
                        echo "<td><a href=\"subject.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "\"><img src=\"../images/icons/application_view_list.png\" width=\"16\" height=\"16\"/></a>&nbsp;";
                        echo "<a href=\"tchgroupbroadsheet.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "\">" . $row['subjectname'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['sgradeid'] . "\">" . $row['A*'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['agradeid'] . "\">" . $row['A'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['bgradeid'] . "\">" . $row['B'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['cgradeid'] . "\">" . $row['C'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['dgradeid'] . "\">" . $row['D'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['egradeid'] . "\">" . $row['E'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['fgradeid'] . "\">" . $row['F'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['ggradeid'] . "\">" . $row['G'] . "</a></td>";
                        echo "<td class=\"gradecell\"><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['ugradeid'] . "\">" . $row['U'] . "</a></td>";

                        echo "<td>" . $total . "</td>";
                        
                        if (isset($_POST['compset']) && $_POST['compset'] != "") {
                            
                            foreach ($compResults as $v) {
                                if ($v['subjectname'] == $row['subjectname']){
                                    
                                    if (($aa / $total) < ($v['aa'] / $v['total'])){
                                        echo "<td class=\"belowtargetcell\">";
                                    }
                                    else if (($aa / $total) > ($v['aa'] / $v['total'])){
                                        echo "<td class=\"abovetargetcell\">";
                                    }
                                    else{
                                        echo "<td class=\"ontargetcell\">";
                                    }
                                    echo  sprintf("%01.1f", (($aa / $total) * 100)) . " (" . sprintf("%01.1f", (($v['aa'] / $v['total']) * 100)) . ")</td>";
                                    
                                    
                                    if (($ac / $total) < ($v['ac'] / $v['total'])){
                                        echo "<td class=\"belowtargetcell\">";
                                    }
                                    else if (($ac / $total) > ($v['ac'] / $v['total'])){
                                        echo "<td class=\"abovetargetcell\">";
                                    }
                                    else{
                                        echo "<td class=\"ontargetcell\">";
                                    }
                                    echo  sprintf("%01.1f", (($ac / $total) * 100)) . " (" . sprintf("%01.1f", (($v['ac'] / $v['total']) * 100)) . ")</td>";
                                    
                                    
                                    if (($ag / $total) < ($v['ag'] / $v['total'])){
                                        echo "<td class=\"belowtargetcell\">";
                                    }
                                    else if (($ag / $total) > ($v['ag'] / $v['total'])){
                                        echo "<td class=\"abovetargetcell\">";
                                    }
                                    else{
                                        echo "<td class=\"ontargetcell\">";
                                    }
                                    echo  sprintf("%01.1f", (($ag / $total) * 100)) . " (" . sprintf("%01.1f", (($v['ag'] / $v['total']) * 100)) . ")</td>";
                                    
                                }
                            }
                        } else {
                            echo "<td>" . sprintf("%01.1f", (($aa / $total) * 100)) . "</td>";
                            echo "<td>" . sprintf("%01.1f", (($ac / $total) * 100)) . "</td>";
                            echo "<td>" . sprintf("%01.1f", (($ag / $total) * 100)) . "</td>";
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