$(document).ready(function() {
    
    $('.button').click(function() {
        $('#login_response').html('<img src="images/ajax/ajax-smlcircle.gif" width="16" height="16" alt="validating..."/>');
        var username = $('#username').val();
        var password = $('#password').val();
        
        $.get("login.php?username="+username+"&password="+password, function (response) {
            if(response == 0){
                $('#username').val(''); 
                $('#password').val(''); 
                $('#login_response').html('Login failed! Please try again...');
            }else {
                window.location = "/databook/index.php";
            }
        
        });
        
    });
    
});    