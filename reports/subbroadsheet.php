<?php
/*
 * Document     : subbroadsheet.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : main "subject" report accessible via the main <nav> menu. Displays
 * a list of subjects down the side and grades across the top. cells contain number
 * of those grades. total columns include stats such as %A*-A and %A*-C's
 * 
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/corefunctions.js"></script>
        <script type="text/javascript">
            /* 
             * jQuery click function for the filter button. loads the selections on the filter into
             * an array which is passed via ajax to the backend php file which talks to the database
             * and produces a html table which is loaded into a <div> on the page
             */
            $(document).ready(function() {
                $('.button').click(function(){    
                    var data = {
                        ds:         $("#selectdataset").val(),
                        cs:         $('#selectcompset').val(),                       
                        male:       $('#male').is(':checked'),
                        female:     $('#female').is(':checked'),
                        fsm:        $('#fsm').is(':checked'),
                        lac:        $('#lac').is(':checked'),
                        ma:         $('#ma').is(':checked')
                    };
                    
                    $.ajax({
                        url:        'ajax/getsubbroadsheet.php',
                        type:       'post',
                        cache:      false,
                        data:       {filter: data},
                        success:    function(data) {
                            $('#subjects').html(data);
                        }
                    });
                });
            });
        </script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Subject Broadsheet</title>        
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">       
               
                <?php include('ajax/filter.php'); ?>                    

                <div id="content">
                    <h2>Subject Broadsheet</h2>
                    <p>Please note there is a known bug relating to filtering on sen details. </p>
                    <div id="subjects"></div>
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>