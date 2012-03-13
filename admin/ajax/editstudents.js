$(document).ready(function() {
    
    $('#year').change(function() {
        $('#selectStudent').html('');
        $('#editStudent').html('');
        var year = $(this).val();        
        $('#selectForm').load("../admin/ajax/getforms.php?year="+year);
    });
    
    $('#form').live("change", function() {
        $('#editStudent').html('');
        var form = $(this).val();        
        $('#selectStudent').load("../admin/ajax/getstudents.php?form="+form);
    }); 
    
    $('.editStuGradesImg').live("click", function() {
        var studentid = $(this).attr("data-studentid");
        $('#editStudent').load("../admin/ajax/editstugrades.php?studentid="+studentid);
    }); 
    
    $('.editStuDetailsImg').live("click", function() {
        var studentid = $(this).attr("data-studentid");
        var year = $(this).attr("data-year");
        $('#editStudent').load("../admin/ajax/getstudetails.php?studentid="+studentid+"&year="+year);
    });

    $('#updateStudentImg').live("click", function() {
        var form = $('#studentform').val();
        var fsm = $('#studentfsm').val();
        var sen = $('#studentsen').val();
        var studentid = $(this).attr("data-studentid");
        $('#updatestudentresponse').load("../admin/ajax/updatestudetails.php?studentid="+studentid+"&form="+form+"&fsm="+fsm+"&sen="+sen);          
    });

    $('.updateStuGrade').live("change", function(){
        var resultid = $(this).attr("data-resultid");
        var scale = $(this).attr("data-scale");
        var newgrade = $(this).val();
        $('#updatestudentresponse').load("../admin/ajax/updatestugrade.php?resultid="+resultid+"&scale="+scale+"&newgrade="+newgrade);
    })
    
    $('#deleteStudentImg').live("click", function() {
        var studentid = $(this).attr("data-studentid");
        $('#updatestudentresponse').load("../admin/ajax/deletestudent.php?studentid="+studentid);          
    });
});