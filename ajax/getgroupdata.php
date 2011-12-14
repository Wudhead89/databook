<?php
/*
  Document   : getgroupdata.php
  Created on : 14-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$groupid = $_GET['groupid'];
$setid = $_SESSION['setid'];

include('../mssql.php');

$sqlstring = "SELECT STUDENTS.StudentId, STUDENTS.Name, STUDENTS.ClassGroupId, CAST(CurYrCATs.vblsas AS INT) AS V, CAST(CurYrCATs.nsas AS INT) AS N, CAST(CurYrCATs.qsas AS INT) AS Q, CAST(CurYrCATs.meansas AS INT) AS M, CurYrSENStages.StageCode ,
                ROUND(CurYrKS4FFT.F_5AC_Est_Y6 * 100, 2) AS FiveAC, ROUND(CurYrKS4FFT.F_5AC_incEM_Est_Y6 * 100, 2) AS FiveEM, ROUND(CurYrKS4FFT.F_5AG_Est_Y6 * 100, 2) AS FiveAG, ROUND(CurYrKS4FFT.Num_AC_Est_Y6, 1) AS NumAC, ROUND(CurYrKS4FFT.Tot_Pts_New_Est_All_Y6, 0) AS APS, ROUND(CurYrKS4FFT.Tot_Pts_Cap_New_Est_All_Y6, 0) AS Capped
                FROM STUGROUPS 
                INNER JOIN STUDENTS ON STUGROUPS.StudentId = STUDENTS.StudentId 
                INNER JOIN CurYrSENStuStages ON STUGROUPS.StudentId = CurYrSENStuStages.StudentId 
                INNER JOIN CurYrSENStages ON CurYrSENStuStages.StageId = CurYrSENStages.StageId 
                LEFT OUTER JOIN CurYrKS4FFT ON STUGROUPS.StudentId = CurYrKS4FFT.StudentId 
                LEFT OUTER JOIN CurYrCATs ON STUGROUPS.StudentId = CurYrCATs.StudentId 
                WHERE STUGROUPS.SetId = '$setid' AND STUGROUPS.GroupId = '$groupid' AND STUDENTS.SetId = '$setid' AND CurYrSENStuStages.EndDate = ''
                ORDER BY STUDENTS.Name";

$studata = sqlsrv_query($conn, $sqlstring);

echo "<table class=\"contenttable\">\n";
echo "<tr>\n";
echo "<th>Name</th>\n";
echo "<th>Form</th>";
echo "<th>V</th>\n";
echo "<th>N</th>\n";
echo "<th>Q</th>\n";
echo "<th>M</th>\n";
echo "<th>5AC</th>\n";
echo "<th>5EM</th>\n";
echo "<th>5AG</th>\n";
echo "<th>APS</th>\n";
echo "<th>Capped</th>\n";
echo "<th>SEN</th>";
echo "</tr>";

while ($row = sqlsrv_fetch_array($studata, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>\n";
    echo "<td>" . $row['Name'] ."</td>\n";
    echo "<td>" . $row['ClassGroupId'] . "</td>\n";
    echo "<td>" . $row['V'] ."</td>\n";
    echo "<td>" . $row['N'] ."</td>\n";
    echo "<td>" . $row['Q'] ."</td>\n";
    echo "<td>" . $row['M'] ."</td>\n";
    echo "<td>" . $row['FiveAC'] ."</td>\n";
    echo "<td>" . $row['FiveEM'] ."</td>\n";
    echo "<td>" . $row['FiveAG'] ."</td>\n";
    echo "<td>" . $row['APS'] ."</td>\n";
    echo "<td>" . $row['Capped'] ."</td>\n";
    echo "<td>" . $row['StageCode'] . "</td>\n";
    echo "</tr>";
}

echo "</table>";
sqlsrv_free_stmt($studata);

sqlsrv_close($conn);
?>
