<!-- 
    Document   : importteachinggroups.php
    Created on : 22-May-2011
    Author     : Richard Williamson
-->

<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css"/>
        <title>Import Teaching Groups</title>
    </head>
    <body>
        <?php
        include('../config.php');

        //echo getSubjectId("Geography"). "<br />"; 
        //echo getSubjectId("English Lang"). "<br />";
        
        $file = fopen("teachinggroups.csv", "r") or exit("Unable to open file!");
        $count = 0;
        $yearid = 1;
        
        while (!feof($file)) {
            $studentid = strtok(fgets($file), ",");
            $subjectname = strtok(",");
            $teachgrpcode = strtok(",");

            $subjectid = trim(getSubjectId($subjectname));

            // echo $yearid . " " . $studentid . " " . $subjectid . " " . $subjectname . " " . $teachgrpcode . "<br />";

            $insertstr = "INSERT INTO tchgroups (yearid, studentid, subjectid, tchgroupcode) VALUES ('$yearid', '$studentid', '$subjectid', '$teachgrpcode');";
            echo $insertstr . "<br / >";            
            
            //mysql_query($insertstr);

            $count++;
        }        
        
        echo $count . " Teaching groups inserted<br />";
        
        function getSubjectId($subject) {
            $result = mysql_query("SELECT subjectid FROM subjects WHERE subjectname=\"" . $subject . "\"");
            while ($row = mysql_fetch_assoc($result)) {
                return $row['subjectid'];
            }
        }
        
        ?>
    </body>
</html>
