<?php
/*
  Document   : stusenreport.php
  Created on : 05-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
include('../mssql.php');
include('../config.php');
include('functions.php');

$studentid = $_GET['studentid'];
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
        <title>Data Book - Student SEN Report</title>
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  

                <?php
                echo "<h2>Student SEN Report: " . getStudentName($studentid) . "</h2>";

                // retrieve student Stages
                echo "<h3>Stages</h3>";
                $sqlstring = "SELECT CurYrSENStages.StageCode, CurYrSENStages.StageDesc, SENSTUSTAGES.StartDate, SENSTUSTAGES.EndDate
                    FROM SENSTUSTAGES 
                    INNER JOIN CurYrStudents ON SENSTUSTAGES.StudentId = CurYrStudents.StudentId
                    INNER JOIN CurYrSENStages ON SENSTUSTAGES.StageId = CurYrSENStages.StageId 
                    WHERE (SENSTUSTAGES.StudentId = $studentid) AND (SENSTUSTAGES.SetId = '" . $_SESSION['setid'] . "')";
                $stuStages = sqlsrv_query($conn, $sqlstring);

                echo "<table class=\"contenttable\">";
                echo "<tr>";
                echo "<td>Stage</td>";
                echo "<td>Description</td>";
                echo "<td>Start</td>";
                echo "<td>End</td>";
                echo "</tr>";

                while ($row = sqlsrv_fetch_array($stuStages, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['StageDesc'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['EndDate'] . "</td>\n";
                    echo "</tr>";
                }
                echo "</table>";

                sqlsrv_free_stmt($stuStages);
                

                // retrieve student Major Needs
                echo "<h3>Major Needs</h3>";
                $sqlstring = "SELECT CurYrNStuRNeeds.Need, CLASSIFICATIONS.Name AS Description 
                    FROM CurYrNStuRNeeds 
                    INNER JOIN CurYrStudents ON CurYrNStuRNeeds.StudentId = CurYrStudents.StudentId 
                    INNER JOIN CLASSIFICATIONS ON CurYrNStuRNeeds.Need = CLASSIFICATIONS.ClassId 
                    WHERE (CurYrNStuRNeeds.StudentId = $studentid) AND (CLASSIFICATIONS.SetId = '" . $_SESSION['setid'] . "') AND (CLASSIFICATIONS.Type = 'SCH_PROV_TYPE')";
                $stuMajorNeeds = sqlsrv_query($conn, $sqlstring);

                echo "<table class=\"contenttable\">";
                echo "<tr>";
                echo "<td>Need</td>";
                echo "<td>Description</td>";
                echo "</tr>";

                while ($row = sqlsrv_fetch_array($stuMajorNeeds, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['Need'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                sqlsrv_free_stmt($stuMajorNeeds);


                // retrieve student strategies
                echo "<h3>Strategies</h3>";
                $sqlstring = "SELECT CurYrSENStages.StageCode, SENTYPES.TypeCode, SENTYPES.TypeName, SENSTUTYPES.TNotes 
                    FROM SENSTUTYPES 
                    INNER JOIN SENTYPES ON SENSTUTYPES.SENTypeId = SENTYPES.SENTypeId 
                    INNER JOIN CurYrStudents ON SENSTUTYPES.StudentId = CurYrStudents.StudentId 
                    INNER JOIN CurYrSENStages ON SENSTUTYPES.StageId = CurYrSENStages.StageId 
                    WHERE (SENSTUTYPES.SetId = '" . $_SESSION['setid'] . "') AND (SENTYPES.SetId = '" . $_SESSION['setid'] . "') AND (SENSTUTYPES.StudentId = $studentid)";
                $stuStrategies = sqlsrv_query($conn, $sqlstring);

                echo "<table class=\"contenttable\">";
                echo "<tr>";
                echo "<td>Stage</td>";
                echo "<td>Type</td>";
                echo "<td>Description</td>";
                echo "<td>Notes</td>";
                echo "</tr>";

                while ($row = sqlsrv_fetch_array($stuStrategies, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['TypeCode'] . "</td>";
                    echo "<td>" . $row['TypeName'] . "</td>";
                    echo "<td>" . $row['TNotes'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                sqlsrv_free_stmt($stuStrategies);


                // retrieve student provisions
                echo "<h3>Provisions</h3>";
                $sqlstring = "SELECT CurYrSENStages.StageCode, CurYrSENProvTypes.ProvCode, CurYrSENProvTypes.ProvName, SENSTUPROVISION.StartDate, SENSTUPROVISION.EndDate, SENSTUPROVISION.PHours, CurYrSENAgencies.AgencyName, SENSTUPROVISION.PNotes
                    FROM SENSTUPROVISION 
                    INNER JOIN CurYrSENProvTypes ON SENSTUPROVISION.ProvTypeId = CurYrSENProvTypes.ProvTypeId 
                    INNER JOIN CurYrSENStages ON SENSTUPROVISION.StageId = CurYrSENStages.StageId 
                    INNER JOIN CurYrStudents ON SENSTUPROVISION.StudentId = CurYrStudents.StudentId 
                    LEFT OUTER JOIN CurYrSENAgencies ON SENSTUPROVISION.AgencyId = CurYrSENAgencies.AgencyId 
                    WHERE (SENSTUPROVISION.SetId = '" . $_SESSION['setid'] . "') AND (SENSTUPROVISION.StudentId = $studentid)";
                $stuProvisions = sqlsrv_query($conn, $sqlstring);

                echo "<table class=\"contenttable\">";
                echo "<tr>";
                echo "<td>Stage</td>";
                echo "<td>Provision</td>";
                echo "<td>Description</td>";
                echo "<td>Start</td>";
                echo "<td>End</td>";
                echo "<td>Hours</td>";
                echo "<td>Agency</td>";
                echo "<td>Notes</td>";
                echo "</tr>";

                while ($row = sqlsrv_fetch_array($stuProvisions, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['ProvCode'] . "</td>";
                    echo "<td>" . $row['ProvName'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['EndDate'] . "</td>";
                    echo "<td>" . $row['PHours'] . "</td>";
                    echo "<td>" . $row['AgencyName'] . "</td>";
                    echo "<td>" . $row['PNotes'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";

                sqlsrv_free_stmt($stuProvisions);

                sqlsrv_close($conn);
                ?>

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>