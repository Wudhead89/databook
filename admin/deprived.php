<!-- 
    Document   : deprived.php
    Created on : 21-Feb-2012
    Author     : Richard Williamson
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css"/>
        <title>Deprived Students</title>
    </head>
    <body>

        <?php
        $file = fopen("deprived.csv", "r") or exit("Unable to open file!");

        while (!feof($file)) {
            $studentid = trim(strtok(fgets($file), ","));

            $insertstr = "UPDATE nstupersonal SET Dep = 1 WHERE studentid = '$studentid'";
            
            echo $insertstr . "</br>";

        }

        fclose($file);
        ?>

    </body>
</html>
