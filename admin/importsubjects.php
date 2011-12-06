<!-- 
    Document   : importsubjects.php
    Created on : 05-May-2011
    Author     : Richard Williamson
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
        <title>Import Subjects</title>
    </head>
    <body>

        <?php
        include('../config.php');

        $file = fopen("subjects.csv", "r") or exit("Unable to open file!");
        $count = 0;

        while (!feof($file)) {
            $yearid = strtok(fgets($file), ",");
            $subjectname = strtok(",");
            $shortname = strtok(",");
            $department = strtok(",");
            $keystage = strtok(",");
            $studyyear = strtok(",");
            $scale = strtok(",");

            //echo $yearid . " " . $name . " " . $shortname . " " . $department . " " . $keystage . " " . $studyyear . " " . $scale . "<br />";

            $insertstr = "INSERT INTO subjects (yearid, subjectname, shortname, department, keystage, studyyear, scale)
              VALUES ('$yearid', '$subjectname', '$shortname', '$department', '$keystage', '$studyyear', '$scale');";
            
            echo $insertstr . "</br>";
            //mysql_query($insertstr);

            $count++;
        }

        echo "Inserted: " . $count . " records";

        fclose($file);
        ?>

    </body>
</html>
