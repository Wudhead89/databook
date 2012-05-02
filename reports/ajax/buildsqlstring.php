<?php
/*
 * Document     : buildsqlstring.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : used to build an sql string based on the options selected by 
 * the user on the page.
*/


function buildSQLString($datasetid, $filter) {
    
    // filter on dataset
    $sqlstring = " WHERE datasetid = '" . $datasetid . "'";
    
    // filter if male
    if (($filter['male'] == 'true') && ($filter['female'] == 'false')) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.gender = 'M'";
        } else {
            $sqlstring .= " AND students.gender = 'M'";
        }
    }

    // filter if female
    if (($filter['female'] == 'true') && ($filter['male'] == 'false')) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= "  WHERE students.gender = 'F'";
        } else {
            $sqlstring .= "  AND students.gender = 'F'";
        }
    }

    // filter on sen status
    if (isset($_POST['sen']) && count($GLOBALS['sen']) == 1) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.sen = '" . $GLOBALS['sen'][0] . "'";
        } else {
            $sqlstring .= " AND students.sen = '" . $GLOBALS['sen'][0] . "'";
        }
    } elseif (isset($_POST['sen']) && count($GLOBALS['sen']) > 1) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.sen = '" . $GLOBALS['sen'][0] . "'";
        } else {
            $sqlstring .= " AND (students.sen = '" . $GLOBALS['sen'][0] . "'";
        }

        for ($i = 1; $i < count($GLOBALS['sen']); $i++) {
            $sqlstring .= " OR students.sen = '" . $GLOBALS['sen'][$i] . "'";
        }
        $sqlstring .= ")";
    }

    // filter on fsm status
    if ($filter['fsm'] == 'true') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.fsm = 'Y'";
        } else {
            $sqlstring .= " AND students.fsm = 'Y'";
        }
    }

    // filter on lac status
    if ($filter['lac'] == 'true') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.lac = 'Y'";
        } else {
            $sqlstring .= " AND students.lac = 'Y'";
        }
    }

    // filter on ma status
    if ($filter['ma'] == 'true') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.catm > 114";
        } else {
            $sqlstring .= " AND students.catm > 114";
        }
    }    
    
    // return the completed sql string
    return $sqlstring;
}
?>