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
            $stats[$k] = sprintf("%01.2f", ($v / $numstudents));
        } else {
            $stats[$k] = sprintf("%01.2f", (($v / $numstudents) * 100));
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
                $compStats[$k] = sprintf("%01.2f", ($v / $numstudents));
            } else {
                $compStats[$k] = sprintf("%01.2f", (($v / $numstudents) * 100));
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/highcharts.js"></script>    
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />

        <?php
        if (isset($_POST['dataset'])) {
            echo "            
            <script type=\"text/javascript\">

                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'graph',
                            defaultSeriesType: 'column',
                            marginRight: 140,
                        },
                        title: {
                            text: 'English Baccalaureate Figures'
                        },
                        xAxis: {
                            categories: [
                                'English', 
                                'Maths', 
                                'Hums', 
                                'MFL',
                                'EBacc'
                            ]
                        },
                        yAxis: {
                            min: 0,
                            max: 100,
                            title: {
                                text: 'Percentage'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -20,
                            y: 100,
                            borderWidth: 0
                        },
                        tooltip: {
                            formatter: function() {
                                return this.y +'%';
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.06,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                name: '$datasetname',
                                data: [" . $stats['eng'] . "," . $stats['mat'] . "," . $stats['hums'] . "," . $stats['mfl'] . "," . $stats['ebacc'] . "]
                            }";
            if (isset($_POST['compset']) && $_POST['compset'] != "") {
                echo ",{ name: '$compsetname',
                                data: [" . $compStats['eng'] . "," . $compStats['mat'] . "," . $compStats['hums'] . "," . $compStats['mfl'] . "," . $compStats['ebacc'] . "]}";
            }
            echo "]
                    });


                });

            </script>           
            ";
        }
        ?>

        <title>Data Book - English Baccalaureate Figures</title>        
    </head>

    <body onload="init()" onresize="movepopup()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">        

                <?php
                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"ebacc.php\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>English Baccalaureate Figures</h2>\n";

                if (isset($_POST['dataset'])) {
                    echo "<table class=\"contenttable\">\n";

                    echo "<tr>\n";
                    echo "<td>Indicator</td>\n";
                    echo "<td>$datasetname</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compsetname . "</td>";
                    }
                    echo "</tr>\n";

                    echo "<tr>\n";
                    echo "<td>Number of Students</td>\n";
                    echo "<td>$numstudents</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compnumstudents . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>English</td>\n";
                    echo "<td>" . $stats['eng'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['eng'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>Maths</td>\n";
                    echo "<td>" . $stats['mat'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['mat'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>Humantities</td>\n";
                    echo "<td>" . $stats['hums'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['hums'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>Modern Language</td>\n";
                    echo "<td>" . $stats['mfl'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['mfl'] . "</td>";
                    }
                    echo "</tr>\n";

                    echo "<tr>\n";
                    echo "<td>English Baccalaureate</td>\n";
                    echo "<td>" . $stats['ebacc'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['ebacc'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "</table>\n";
                }
                ?>

                <div id="graph" style="width: 100%; height: 350px;"></div>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

    </div> <!-- end of container -->

</body>
</html>