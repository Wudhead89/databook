<?php
/*
  Document   : userlogin.php
  Created on : 31-Mar-2021
  Author     : Richard Williamson
 */
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="js/jquery.min.js"></script>    
        <script src="ajax/login.js"></script>
        <link rel="stylesheet" href="css/login.css" />
        <title>Data Book - Login</title>
    </head>

    <body>

        <div id="wrapper">

            <div id="login">

                <h1>Swanwick <span class="red">Hall</span> School Databook</h1> 
                <p> 
                    <label for="username" data-icon="u" > Username </label>
                    <input id="username" required="required" type="text" placeholder="enter your username" />
                </p>
                <p> 
                    <label for="password" data-icon="p"> Password </label>
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
