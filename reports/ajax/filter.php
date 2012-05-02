<?php
/*
  Document   : filter.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
?>

<div id="filter">

    <h3>Filter</h3>

    <table class="filtertable">
        <tr>
            <td>Dataset</td>
            <td>    
                <select id="selectdataset"></select>
            </td>
        </tr>
        <tr>
            <td>Compare</td>
            <td>    
                <select id="selectcompset"></select>
            </td>
        </tr>
        <tr>
            <td>Gender</td>
            <td>
                M <input type="checkbox" id="male" value="ON" />&nbsp;
                F <input type="checkbox" id="female" value="ON" />
            </td>
        </tr>
        <tr>
            <td>SEN</td>
            <td>
                N <input type="checkbox" name="sen[]" value="N" />
                S <input type="checkbox" name="sen[]" value="S" /> <br />
                P <input type="checkbox" name="sen[]" value="P" />
                A <input type="checkbox" name="sen[]" value="A" />
            </td>
        </tr>
        <tr>
            <td>FSM</td>
            <td>
                <input type="checkbox" id="fsm" value="ON" />
            </td>
        </tr>
        <tr>
            <td>LAC</td>
            <td>
                <input type="checkbox" id="lac" value="ON" />
            </td>
        </tr>
        <tr>
            <td>MA</td>
            <td>
                <input type="checkbox" id="ma" value="ON" />
            </td>
        </tr>
    </table>

    <a href="#" class="button">
        <span class="filter">Apply Filter</span>
    </a>

</div>