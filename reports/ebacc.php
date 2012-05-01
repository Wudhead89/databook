<?php
/*
  Document   : ebacc.php
  Created on : 01-Feb-2012
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

if (isset($_POST['compset'])) {
    $compsetid = $_POST['compset'];
} else if (isset($_GET['compsetid'])) {
    $compsetid = $_GET['compsetid'];
}

if (isset($_POST['dataset'])) {
    $datasetid = $_POST['dataset'];
    $datasetname = getDataSetName($datasetid);
    $numstudents = getNumStudents($datasetid);
    $numstudentsyear = getNumStudentsPerYear(getDataSetYear($datasetid));

    $stats = array(
        "eng" => 0,
        "mat" => 0,
        "hums" => 0,
        "mfl" => 0,
        "ebacc" => 0
    );

    $results = getResults($datasetid);

    while ($result = mysql_fetch_assoc($results)) {
        if ($result['eng'] == 1) {
            $stats['eng']++;
        }
        if ($result['mat'] == 1) {
            $stats['mat']++;
        }
        if ($result['hums'] == 1) {
            $stats['hums']++;
        }
        if ($result['mfl'] == 1) {
            $stats['mfl']++;
        }
        if (($result['eng'] + $result['mat'] + $result['hums'] + $result['mfl']) == 4) {
            $stats['ebacc']++;
        }
    }

    foreach ($stats as $k => $v) {
        if ($k == 'Total Points') {
            $stats[$k] = sprintf("%01.2f", ($v / $numstudentsyear));
        } else {
            $stats[$k] = sprintf("%01.2f", (($v / $numstudentsyear) * 100));
        }
    }

    if (isset($_POST['compset']) && $_POST['compset'] != "") {
        $compsetid = $_POST['compset'];
        $compsetname = getDataSetName($compsetid);
        $compnumstudents = getNumStudents($compsetid);

        $compStats = array(
            "eng" => 0,
            "mat" => 0,
            "hums" => 0,
            "mfl" => 0,
            "ebacc" => 0
        );

        $results = getResults($compsetid);

        while ($result = mysql_fetch_assoc($results)) {
            if ($result['eng'] == 1) {
                $compStats['eng']++;
            }
            if ($result['mat'] == 1) {
                $compStats['mat']++;
            }
            if ($result['hums'] == 1) {
                $compStats['hums']++;
            }
            if ($result['mfl'] == 1) {
                $compStats['mfl']++;
            }
            if (($result['eng'] + $result['mat'] + $result['hums'] + $result['mfl']) == 4) {
                $compStats['ebacc']++;
            }
        }

        foreach ($compStats as $k => $v) {
            if ($k == 'Total Points') {
                $compStats[$k] = sprintf("%01.2f", ($v / $numstudentsyear));
            } else {
                $compStats[$k] = sprintf("%01.2f", (($v / $numstudentsyear) * 100));
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/highcharts.js"></script>  
        <script src="../js/highcharts.vis.js"></script>  
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

        <script type="text/javascript">

            $(document).ready(function() {

                var table = $('.contenttable');
                var options = {
                    chart: {
                        renderTo: 'graph',
                        type: 'column'
                    },
                    title: {
                        text: 'English Baccalaureate'
                    },
                    xAxis: {
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'Percent'
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return this.series.name + ' '+ this.y;
                        }
                    }
                };

                Highcharts.visualize(table, options);
            });
                      
        </script>

        <title>Data Book - English Baccalaureate</title>        
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">        

                
                <div id="filter">
                <form name="filter" action="ebacc.php" method="post">
                <?php include('filter.php'); ?>
                </form>
                </div>  <!-- end filter -->

                <div id="content">
                <h2>English Baccalaureate</h2>

                <?php
                if (isset($_POST['dataset']) && (isset($_POST['compset']) && $_POST['compset'] != "")) {

                    echo "<p>";
                    echo "Number of Students in the year group = $numstudentsyear</br>";
                    echo "Number of Students in the dataset ($datasetname) = $numstudents</br>";
                    echo "Number of Students in the dataset ($compsetname) = $compnumstudents</br>";
                    echo "</p>";

                    echo "<table class=\"contenttable\">";

                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Indicator</th>";
                    echo "<th>$datasetname</th>";
                    echo "<th>$compsetname</th>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";
                    echo "<tr>";
                    echo "<th>English</th>";
                    echo "<td>" . $stats['eng'] . "</td>";
                    echo "<td>" . $compStats['eng'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Maths</th>";
                    echo "<td>" . $stats['mat'] . "</td>";
                    echo "<td>" . $compStats['mat'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Humantities</th>";
                    echo "<td>" . $stats['hums'] . "</td>\n";
                    echo "<td>" . $compStats['hums'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Modern Language</th>";
                    echo "<td>" . $stats['mfl'] . "</td>";
                    echo "<td>" . $compStats['mfl'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>English Baccalaureate</th>";
                    echo "<td>" . $stats['ebacc'] . "</td>";
                    echo "<td>" . $compStats['ebacc'] . "</td>";
                    echo "</tr>";
                    echo "</tbody>";

                    echo "</table>";
                    
                } else if (isset($_POST['dataset'])) {

                    echo "<p>";
                    echo "Number of Students in the year group = $numstudentsyear</br>";
                    echo "Number of Students in the dataset ($datasetname) = $numstudents</br>";
                    echo "</p>";

                    echo "<table class=\"contenttable\">";

                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Indicator</th>";
                    echo "<th>$datasetname</th>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";
                    echo "<tr>";
                    echo "<th>English</th>";
                    echo "<td>" . $stats['eng'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Maths</th>";
                    echo "<td>" . $stats['mat'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Humantities</th>";
                    echo "<td>" . $stats['hums'] . "</td>\n";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>Modern Language</th>";
                    echo "<td>" . $stats['mfl'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th>English Baccalaureate</th>";
                    echo "<td>" . $stats['ebacc'] . "</td>";
                    echo "</tr>";
                    echo "</tbody>";

                    echo "</table>";
                }
                ?>

                <div id="graph"></div>


            </div> <!-- end content -->

        </div> <!-- end content-container -->

        <?php include('../footer.php'); ?>

    </div> <!-- end of container -->

</body>
</html>