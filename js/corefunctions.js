/*
 * Document     : corefunctions.js
 * Created on   : 28-04-2012
 * Author       : Richard Williamson
 * 
 * Description  : A set of standard javascript snipets that are used on most pages
 */
$(document).ready(function(){
    init();
    
    if ($('#selectdataset').length > 0){
        $('#selectdataset').load("ajax/getdsselect.php")
    }
    if ($('#selectcompset').length > 0){
        $('#selectcompset').load("ajax/getcsselect.php")
    }

});

$(document).resize(function(){
    movepopup()
});

$(document).click(function(){
    clearTable();
});