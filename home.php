<?php
/*
 * Document     : index.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : Main home page once user has successfully logged in
 */
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="js/jquery.min.js"></script>
        <script src="ajax/stusearch.js"></script>   
        <script src="js/corefunctions.js"></script>     
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->   
        <link rel="stylesheet" href="css/stylesheet.css" />
        <link rel="stylesheet" href="css/div.css" />
        <title>Data Book - Home</title>
    </head>

    <body>

        <div id="container">

            <?php include('header.php'); ?>

            <div id="content-container">

                <div id="content">

                    <h2>Welcome</h2>
                    <p>Welcome to Swanwick <span class="red">Hall</span> School Databook</p>
                    <p>Here you can find a wealth of information on students, assessments and subjects all in one place. Various sets of reports are available from the top
                    menu relating to assessment data entered into ePortal.</p>
                    <p>You will be able to see the overall "headline" figures for 5A*-C's and 5A*-C inc English & Maths. Also from the
                    "Subjects" menu you will be able to see information for a particular dataset by subject. With this report you can drill down into the data by clicking
                    on subjects to see the teaching within and also by clicking on grades to see the students behind the numbers.</p>
                    <p>On all of the screens you will see a filter on the left hand side of the pages which will allow you to select a dataset and filter the data
                        by gender, fsm, sen and so forth.</p>

                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
