
<?php
include('../../config.php');
$datasets = mysql_query("SELECT * FROM datasets");
echo "<option value=\"\"></option>";
while ($ds = mysql_fetch_assoc($datasets)) {
    echo "<option value=\"" . $ds['datasetid'] . "\">" . $ds['datasetname'] . "</option>";
}
?>