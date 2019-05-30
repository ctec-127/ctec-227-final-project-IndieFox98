<!-- Database connection include file -->

<?php
    $db = new mysqli("localhost", "root", "", "imgload");

    if ($db->connect_error) {
        $error = $db->connect_error;
        echo $error;
    }

    $db->set_charset('utf8');
?>