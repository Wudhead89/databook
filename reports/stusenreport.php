<?php
/*
    Document   : stusenreport.php
    Created on : 05-Dec-2011
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../ajax/stusearch.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Student SEN Report</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  
                <?php
                include('../mssql.php');
                include('../config.php');
                include('functions.php');
                
                $studentid = $_GET['studentid'];

                echo "<h2>Student SEN Report: " . getStudentName($studentid) . "</h2>\n";
                
                // retrieve student Stages
                echo "<h3>Stages</h3>";
                $sqlstring = "SELECT CurYrSENStages.StageCode, CurYrSENStages.StageDesc, SENSTUSTAGES.StartDate, SENSTUSTAGES.EndDate
                    FROM SENSTUSTAGES 
                    INNER JOIN CurYrStudents ON SENSTUSTAGES.StudentId = CurYrStudents.StudentId
                    INNER JOIN CurYrSENStages ON SENSTUSTAGES.StageId = CurYrSENStages.StageId 
                    WHERE (SENSTUSTAGES.StudentId = $studentid) AND (SENSTUSTAGES.SetId = '" . $_SESSION['setid'] . "')";
                $stuStages = sqlsrv_query($conn, $sqlstring);

                echo "<table class=\"contenttable\">\n";
                echo "<tr>\n";
                echo "<td>Stage</td>";
                echo "<td>Description</td>";
                echo "<td>Start</td>";
                echo "<td>End</td>\n";
                echo "</tr>\n";
                
                while ($row = sqlsrv_fetch_array($stuStages, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>\n";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['StageDesc'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['EndDate'] . "</td>\n";
                    echo "</tr>\n";
                }                
                echo "</table>\n";
                
                sqlsrv_free_stmt($stuStages);
                
                                
                // retrieve student Major Needs
                echo "<h3>Major Needs</h3>";
                $sqlstring = "SELECT CurYrNStuRNeeds.Need, CLASSIFICATIONS.Name AS Description 
                    FROM CurYrNStuRNeeds 
                    INNER JOIN CurYrStudents ON CurYrNStuRNeeds.StudentId = CurYrStudents.StudentId 
                    INNER JOIN CLASSIFICATIONS ON CurYrNStuRNeeds.Need = CLASSIFICATIONS.ClassId 
                    WHERE (CurYrNStuRNeeds.StudentId = $studentid) AND (CLASSIFICATIONS.SetId = '" . $_SESSION['setid'] . "') AND (CLASSIFICATIONS.Type = 'SCH_PROV_TYPE')";
                $stuMajorNeeds = sqlsrv_query($conn, $sqlstring);
                
                echo "<table class=\"contenttable\">\n";
                echo "<tr>\n";
                echo "<td>Need</td>";
                echo "<td>Description</td>\n";
                echo "</tr>\n";
                
                while ($row = sqlsrv_fetch_array($stuMajorNeeds, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>\n";
                    echo "<td>" . $row['Need'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                
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
                
                echo "<table class=\"contenttable\">\n";
                echo "<tr>\n";
                echo "<td>Stage</td>";
                echo "<td>Type</td>";
                echo "<td>Description</td>";
                echo "<td>Notes</td>\n";
                echo "</tr>\n";
                
                while ($row = sqlsrv_fetch_array($stuStrategies, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>\n";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['TypeCode'] . "</td>";
                    echo "<td>" . $row['TypeName'] . "</td>";
                    echo "<td>" . $row['TNotes'] . "</td>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                
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
                
                echo "<table class=\"contenttable\">\n";
                echo "<tr>\n";
                echo "<td>Stage</td>";
                echo "<td>Provision</td>";
                echo "<td>Description</td>";
                echo "<td>Start</td>";
                echo "<td>End</td>";
                echo "<td>Hours</td>";
                echo "<td>Agency</td>";                
                echo "<td>Notes</td>\n";
                echo "</tr>\n";
                
                while ($row = sqlsrv_fetch_array($stuProvisions, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>\n";
                    echo "<td>" . $row['StageCode'] . "</td>";
                    echo "<td>" . $row['ProvCode'] . "</td>";
                    echo "<td>" . $row['ProvName'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['EndDate'] . "</td>";
                    echo "<td>" . $row['PHours'] . "</td>";
                    echo "<td>" . $row['AgencyName'] . "</td>";
                    echo "<td>" . $row['PNotes'] . "</td>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                
                sqlsrv_free_stmt($stuProvisions);
                
                sqlsrv_close($conn);
                ?>

        </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>