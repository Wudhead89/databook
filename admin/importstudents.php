<!-- 
    Document   : importstudents.php
    Created on : 14-Nov-2011
    Author     : Richard Williamson
-->

<!DOCTYPE html>

<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <title>Import Students</title>
    </head>
    <body>

        <?php
        include('../config.php');

        $file = fopen("students.csv", "r") or exit("Unable to open file!");
        $count = 0;

        while (!feof($file)) {
            $studentid = strtok(fgets($file), ",");
            $surname = strtok(",");
            $forename = strtok(",");
            $form = strtok(",");
            $year = strtok(",");
            $gender = strtok(",");
            $sen = strtok(",");
            $fsm = strtok(",");
            $lac = strtok(",");
            $ks2 = strtok(",");
            $catn = strtok(",");
            $catv = strtok(",");
            $catq = strtok(",");
            $catm = trim(strtok(","));
            

            //echo $studentid . " " . $surname . " " . $forename . " " . $form . " " . $year . " " . $gender . " " . $sen . " " . $fsm . " " . $lac . " " . $ks2 . " " . $catn . " " . $catv . " " . $catq . " " . $catm . "<br />";

            $insertstr = "INSERT INTO students (studentid, surname, forename, form, year, gender, sen, fsm, lac, ks2, catn, catv, catq, catm)
              VALUES ('$studentid', '$surname', '$forename', '$form', '$year', '$gender', '$sen', '$fsm', '$lac', '$ks2', '$catn', '$catv', '$catq', '$catm')";
            
            echo $insertstr . "</br>";
            mysql_query($insertstr);

            $count++;
        }

        echo "Inserted: " . $count . " records";

        fclose($file);
        ?>

    </body>
</html>
