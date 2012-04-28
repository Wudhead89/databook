<?php
include('../../config.php');
$datasets = mysql_query("SELECT * FROM datasets");
while ($ds = mysql_fetch_assoc($datasets)) {
    echo "<option value=\"" . $ds['datasetid'] . "\">" . $ds['datasetname'] . "</option>";
}
?>