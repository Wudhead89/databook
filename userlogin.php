<?php
/*
 * Document     : userlogin.php
 * Created on   : 31-Mar-2012
 * Author       : Richard Williamson
 * 
 * Description  : userlogin page. content only in this php file, login code is hadnled via jQuery/AJAX in login.js
 */
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="js/jquery.min.js"></script>    
        <script src="ajax/login.js"></script>
        
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->      
        
        <link rel="stylesheet" href="css/login.css" />
        <title>Data Book - Login</title>
    </head>

    <body>

        <div id="wrapper">

            <div id="login">

                <h1>Swanwick <span class="red">Hall</span> School Databook</h1> 
                <p> 
                    <label for="username" data-icon="A" > Username </label>
                    <input id="username" required="required" type="text" placeholder="enter your username" />
                </p>
                <p> 
                    <label for="password" data-icon="L"> Password </label>
                    <input id="password" required="required" type="password" placeholder="enter your password" /> 
                </p>
                <p class="button"> 
                    <input type="submit" value="Login" /> 
                </p>
                <div id="login_response"></div>

            </div>

        </div>

    </body>
</html>
