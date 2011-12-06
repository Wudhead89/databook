<!-- 
    Document   : importresults.php
    Created on : 05-May-2011
    Author     : Richard Williamson
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
        <title>Import Results</title>
    </head>
    <body>
        <?php
        include('../config.php');

        //echo getSubjectId("Geography"). "<br />"; 
        //echo getSubjectId("English Lang"). "<br />";
        //$scale = trim(getScale(getSubjectId("Geography")));
        //echo getGradeId($scale, "A"). "<br />";
        //echo getGradeId($scale, "A*"). "<br />";
        
        $file = fopen("results.csv", "r") or exit("Unable to open file!");
        $count = 0;

        while (!feof($file)) {
            $yearid = strtok(fgets($file), ",");
            $datasetid = strtok(",");
            $studentid = strtok(",");
            $subjectname = strtok(",");
            $scale = strtok(",");
            $grade = strtok(",");
            
            $scale = trim(getScale(getSubjectId($subjectname)));
            $subjectid = trim(getSubjectId($subjectname));
            $grade = trim($grade);
            $gradeid = getGradeId($scale, $grade);

            //echo $yearid . " " . $datasetid . " " . $studentid . " " . $subjectid . " " . $subjectname . " " . $scale . " " . $grade . " " . $gradeid . "<br />";

            $insertstr = "INSERT INTO results (yearid, datasetid, studentid, subjectid, gradeid) VALUES ('$yearid', '$datasetid', '$studentid', '$subjectid', '$gradeid');";
            echo $insertstr . "<br />";            
            
            mysql_query($insertstr);

            $count++;
        }        
        
        echo $count . " Results inserted<br />";
        
        function getSubjectId($subject) {
            $result = mysql_query("SELECT subjectid FROM subjects WHERE subjectname=\"" . $subject . "\"");
            while ($row = mysql_fetch_assoc($result)) {
                return $row['subjectid'];
            }
        }
        
        function getGradeId($scale, $grade) {
            $result = mysql_query("SELECT gradeid FROM grades WHERE scale=\"" . $scale . "\" AND grade=\"" . $grade ."\"");
            while ($row = mysql_fetch_array($result)) {
                return $row['gradeid'];
            }
        }
        
        function getScale($subjectid) {
            $result = mysql_query("SELECT scale FROM subjects WHERE subjectid=\"" . $subjectid . "\"");
            while ($row = mysql_fetch_array($result)) {
                return $row['scale'];
            }
        }
        
        ?>
    </body>
</html>
