$(document).ready(function() {
    
    $('#loginImg').click(function() {
        $('#login_response').html('Validating...');
        var username = $('#username').val();
        var password = $('#password').val();
        
        $.get("login.php?username="+username+"&password="+password, function (response) {
            if(response == 0){
                $('#username').val(''); 
                $('#password').val(''); 
                $('#login_response').html('Login failed! Please try again');
            }else {
                window.location = "/databook/index.php";
            }
        
        });
        
    });
    
});    
