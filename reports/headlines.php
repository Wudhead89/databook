<?php
/*
  Document   : headlines.php
  Created on : 05-May-2011
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
        "5AA" => 0,
        "5AC" => 0,
        "5EM" => 0,
        "5AG" => 0,
        "1AC" => 0,
        "1AG" => 0,
        "Total Points" => 0
    );

    $results = getResults($datasetid);

    while ($result = mysql_fetch_assoc($results)) {
        if ($result['aa'] >= 5) {
            $stats['5AA']++;
        }
        if ($result['clevel2'] >= 1) {
            $stats['5AC']++;
        }
        if ($result['eng'] == 1 && $result['mat'] == 1) {
            $stats['5EM']++;
        }
        if ($result['clevel1'] >= 1) {
            $stats['5AG']++;
        }
        if ($result['ac'] >= 1) {
            $stats['1AC']++;
        }
        if ($result['ag'] >= 1) {
            $stats['1AG']++;
        }

        $stats['Total Points'] += $result['points'];
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
            "5AA" => 0,
            "5AC" => 0,
            "5EM" => 0,
            "5AG" => 0,
            "1AC" => 0,
            "1AG" => 0,
            "Total Points" => 0
        );

        $results = getResults($compsetid);

        while ($result = mysql_fetch_assoc($results)) {
            if ($result['aa'] >= 5) {
                $compStats['5AA']++;
            }
            if ($result['clevel2'] >= 1) {
                $compStats['5AC']++;
            }
            if ($result['eng'] == 1 && $result['mat'] == 1) {
                $compStats['5EM']++;
            }
            if ($result['clevel1'] >= 1) {
                $compStats['5AG']++;
            }
            if ($result['ac'] >= 1) {
                $compStats['1AC']++;
            }
            if ($result['ag'] >= 1) {
                $compStats['1AG']++;
            }

            $compStats['Total Points'] += $result['points'];
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

        <script type="text/javascript">

            $(document).ready(function() {
                /**
                 * Visualize an HTML table using Highcharts. The top (horizontal) header
                 * is used for series names, and the left (vertical) header is used
                 * for category names. This function is based on jQuery.
                 * @param {Object} table The reference to the HTML table to visualize
                 * @param {Object} options Highcharts options
                 */
                Highcharts.visualize = function(table, options) {
                    // the categories
                    options.xAxis.categories = [];
                    $('tbody th', table).each( function(i) {
                        options.xAxis.categories.push(this.innerHTML);
                    });

                    // the data series
                    options.series = [];
                    $('tr', table).each( function(i) {
                        var tr = this;
                        $('th, td', tr).each( function(j) {
                            if (j > 0) { // skip first column
                                if (i == 0) { // get the name and init the series
                                    options.series[j - 1] = {
                                        name: this.innerHTML,
                                        data: []
                                    };
                                } else { // add values
                                    options.series[j - 1].data.push(parseFloat(this.innerHTML));
                                }
                            }
                        });
                    });

                    var chart = new Highcharts.Chart(options);
                }

                var table = $('.contenttable');
                var options = {
                    chart: {
                        renderTo: 'graph',
                        type: 'column'
                    },
                    title: {
                        text: 'Headling Figures'
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

        <title>Data Book - Headline Figures</title>        
    </head>

    <body onload="init()" onresize="movepopup()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">        


                <div id="filter">
                    <form name="filter" action="headlines.php" method="post">
                        <?php include('filter.php'); ?>
                    </form>
                </div>  <!-- end filter -->

                <div id="content">
                    <h2>Headline Figures</h2>

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
                        echo "<th>5AA</th>";
                        echo "<td>" . $stats['5AA'] . "</td>";
                        echo "<td>" . $compStats['5AA'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>5AC</th>";
                        echo "<td>" . $stats['5AC'] . "</td>";
                        echo "<td>" . $compStats['5AC'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>5EM</th>";
                        echo "<td>" . $stats['5EM'] . "</td>\n";
                        echo "<td>" . $compStats['5EM'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>1AC</th>";
                        echo "<td>" . $stats['1AC'] . "</td>\n";
                        echo "<td>" . $compStats['1AC'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>1AG</th>";
                        echo "<td>" . $stats['1AG'] . "</td>\n";
                        echo "<td>" . $compStats['1AG'] . "</td>";
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
                        echo "<th>5AA</th>";
                        echo "<td>" . $stats['5AA'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>5AC</th>";
                        echo "<td>" . $stats['5AC'] . "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>5EM</th>";
                        echo "<td>" . $stats['5EM'] . "</td>\n";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>1AC</th>";
                        echo "<td>" . $stats['1AC'] . "</td>\n";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<th>1AG</th>";
                        echo "<td>" . $stats['1AG'] . "</td>\n";
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