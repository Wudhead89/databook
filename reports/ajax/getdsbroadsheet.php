<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Home</title>
    </head>

    <body>

        <?php
        include('../../config.php');

        if (isset($_GET['dataset'])) {
            $datasetid = $_GET['dataset'];

            $result = mysql_query("SELECT DISTINCT CONCAT(', GROUP_CONCAT(IF(shortname = \"',shortname,'\", grade,null)) AS `',shortname,'`') AS subjects FROM results_view WHERE datasetid = '$datasetid'");

            $selectstr = "SELECT CONCAT(surname, \", \", forename) AS studentname";
            while ($row = mysql_fetch_assoc($result)) {
                $selectstr = $selectstr . $row['subjects'];
            }
            $selectstr = $selectstr . " FROM results_view WHERE datasetid = '$datasetid' GROUP BY studentname";
            $result = mysql_query($selectstr);

            $subjects = mysql_query("SELECT DISTINCT shortname FROM results_view where datasetid = '$datasetid' ORDER BY shortname");

            echo "<table class=\"contenttable\">";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Student Name</th>";

            while ($subject = mysql_fetch_assoc($subjects)) {
                echo "<th>" . $subject['shortname'] . "</th>";
            }
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            while ($row = mysql_fetch_assoc($result)) {
                echo "<tr>";
                echo "<th>" . $row['studentname'] . "</th>";
                mysql_data_seek($subjects, 0);
                while ($subject = mysql_fetch_assoc($subjects)) {
                    echo "<td>" . $row[$subject['shortname']] . "</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        ?>
    </body>
</html>
