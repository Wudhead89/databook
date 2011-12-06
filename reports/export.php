<?php
/* 
    Document   : export.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/
    
include('../config.php');
export("SELECT * FROM datasets");

function export($sqlstring) {

    $datasets = mysql_query($sqlstring);
    while ($row = mysql_fetch_assoc($datasets)) {
        $aData[] = $row;
    }
    
    //feed the final array to our formatting function...
    $contents = getExcelData($aData);

    $filename = "export.csv";

    //prepare to give the user a Save/Open dialog...
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $filename);

    //setting the cache expiration to 30 seconds ahead of current time. an IE 8 issue when opening the data directly in the browser without first saving it to a file
    $expiredate = time() + 30;
    $expireheader = "Expires: " . gmdate("D, d M Y G:i:s", $expiredate) . " GMT";
    header($expireheader);

    echo $contents;
}

function getExcelData($data) {
    
    $retval = "";    
    if (is_array($data) && !empty($data)) { 
        
        $row = 0;     
        foreach (array_values($data) as $_data) {
            
            if (is_array($_data) && !empty($_data)) {
                if ($row == 0) {
                    // write the column headers
                    $retval = implode("\t", array_keys($_data));
                    $retval .= "\n";
                }
                //create a line of values for this row...
                $retval .= implode("\t", array_values($_data));
                $retval .= "\n";
                //increment the row so we don't create headers all over again
                $row++;
            }
        }
    }
    
    return $retval;
}
?>