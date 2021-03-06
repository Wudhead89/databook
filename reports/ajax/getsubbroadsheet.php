<?php
/*
 * Document     : subbroadsheet.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : called from subbroadsheet.php report. generates a html tables 
 * containing subjects down the side, grades across the top and numbers of those
 * grades in each cell along with some total columns. a comparison dataset is
 * optional. 
 * 
 * Params       : _POST['filter'] is an array containing the information selected 
 * in the filter by the user
 */

include('../../config.php');
include('buildsqlstring.php');

$filter = $_POST["filter"];
$datasetid = $filter['ds'];

// main sql string prefix, stored as a variable as it is used twice if there is a 
// comparison dataset
$sqlstringprefix = "SELECT subjects.subjectname, results.subjectid, 
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

// if a compare dataset is selected load the results into an array for later use.
if ($filter['cs'] != "") {

    // build the sql string
    $sqlstring = $sqlstringprefix;
    $sqlstring .= buildSQLString($filter['cs'], $filter);
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


// build the sql string to query the database
$sqlstring = $sqlstringprefix;
$sqlstring .= buildSQLString($filter['ds'], $filter);
$sqlstring .= " GROUP BY subjects.subjectname";

$result = mysql_query($sqlstring);

// output html table header
echo "<table class=\"contenttable\">
        <thead>
        <tr>
        <td>Subject Name</td>
        <th>A*</th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th><th>F</th><th>G</th><th>U</th>
        <th>Total</th>
        <th>%AA</th>
        <th>%AC</th>
        <th>%AG</th>
        </tr>
        </thead>";

echo "<tbody>";

// for every row returned from sql print out a row in the html table. one row per subject
while ($row = mysql_fetch_assoc($result)) {
    $total = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'] + $row['U'];
    $aa = $row['A*'] + $row['A'];
    $ac = $row['A*'] + $row['A'] + $row['B'] + $row['C'];
    $ag = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'];

    echo "<tr>";
    echo "<th><a href=\"tchgroupbroadsheet.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "\">" . $row['subjectname'] . "</a></th>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['sgradeid'] . "\">" . $row['A*'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['agradeid'] . "\">" . $row['A'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['bgradeid'] . "\">" . $row['B'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['cgradeid'] . "\">" . $row['C'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['dgradeid'] . "\">" . $row['D'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['egradeid'] . "\">" . $row['E'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['fgradeid'] . "\">" . $row['F'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['ggradeid'] . "\">" . $row['G'] . "</a></td>";
    echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&amp;subjectid=" . $row['subjectid'] . "&amp;gradeid=" . $row['ugradeid'] . "\">" . $row['U'] . "</a></td>";

    echo "<td>" . $total . "</td>";

    if ($filter['cs'] != "") {

        foreach ($compResults as $v) {
            if ($v['subjectname'] == $row['subjectname']) {

                if (($aa / $total) < ($v['aa'] / $v['total'])) {
                    echo "<td class=\"belowtargetcell\">";
                } else if (($aa / $total) > ($v['aa'] / $v['total'])) {
                    echo "<td class=\"abovetargetcell\">";
                } else {
                    echo "<td>";
                }
                echo sprintf("%01.1f", (($aa / $total) * 100)) . " (" . sprintf("%01.1f", (($v['aa'] / $v['total']) * 100)) . ")</td>";


                if (($ac / $total) < ($v['ac'] / $v['total'])) {
                    echo "<td class=\"belowtargetcell\">";
                } else if (($ac / $total) > ($v['ac'] / $v['total'])) {
                    echo "<td class=\"abovetargetcell\">";
                } else {
                    echo "<td>";
                }
                echo sprintf("%01.1f", (($ac / $total) * 100)) . " (" . sprintf("%01.1f", (($v['ac'] / $v['total']) * 100)) . ")</td>";


                if (($ag / $total) < ($v['ag'] / $v['total'])) {
                    echo "<td class=\"belowtargetcell\">";
                } else if (($ag / $total) > ($v['ag'] / $v['total'])) {
                    echo "<td class=\"abovetargetcell\">";
                } else {
                    echo "<td>";
                }
                echo sprintf("%01.1f", (($ag / $total) * 100)) . " (" . sprintf("%01.1f", (($v['ag'] / $v['total']) * 100)) . ")</td>";
            }
        }
    } else {
        echo "<td>" . sprintf("%01.1f", (($aa / $total) * 100)) . "</td>";
        echo "<td>" . sprintf("%01.1f", (($ac / $total) * 100)) . "</td>";
        echo "<td>" . sprintf("%01.1f", (($ag / $total) * 100)) . "</td>";
    }

    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>