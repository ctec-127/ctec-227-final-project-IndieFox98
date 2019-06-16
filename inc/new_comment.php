<?php
    session_start();

    require_once "new_mysqli.php";

    $date = $db->real_escape_string(date("Y/m/d H:i:s"));

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $sql = "INSERT INTO comment (comment_string, user_id, image_id, comment_date) 
                VALUES ('" . $_POST['comment'] . "', '" . $_SESSION['id'] . "', '" . $_POST['img_id'] . "', '" . $date . "')";
        
        $result = $db->query($sql);
    } else {
        header("location: ../index.php");
    }
?>