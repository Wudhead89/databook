/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    init();
    
    if ($("#selectdataset").length > 0){
        $('#selectdataset').load("ajax/getdsselect.php")
    }
});
$(document).resize(function(){
    movepopup()
});
$(document).click(function(){
    clearTable();
});
