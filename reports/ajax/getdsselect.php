<?php
/*
 * Document     : getdsselect.php
 * Created on   : 02-May-2012
 * Author       : Richard Williamson
 * 
 * Description  : generates the values for the dataset drop down menu. called via
 * jQuery in corefunctions.js
 */
include('../../config.php');
$datasets = mysql_query("SELECT * FROM datasets");
while ($ds = mysql_fetch_assoc($datasets)) {
    echo "<option value=\"" . $ds['datasetid'] . "\">" . $ds['datasetname'] . "</option>";
}
?>