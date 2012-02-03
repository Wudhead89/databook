<?php

// using ldap bind
$user  = 'stafftest';     // ldap rdn or dn
$pass = 'Rainbow6';  // associated password

// connect to ldap server
$conn = ldap_connect("ldap://services.swanwickhall.derbyshire.sch.uk")
    or die("Could not connect to LDAP server.");

ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($conn) {

    $bind = ldap_bind($conn, $user, $pass)
            or die("Could not bind.");

    if ($bind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }

}

?>