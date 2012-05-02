<?php
/*
 * Document     : getcsselect.php
 * Created on   : 02-May-2012
 * Author       : Richard Williamson
 * 
 * Description  : generates the values for the compare dataset drop down menu. called via
 * jQuery in corefunctions.js
 */

include('../../config.php');
$datasets = mysql_query("SELECT * FROM datasets");
echo "<option value=\"\"></option>";
while ($ds = mysql_fetch_assoc($datasets)) {
    echo "<option value=\"" . $ds['datasetid'] . "\">" . $ds['datasetname'] . "</option>";
}
?>