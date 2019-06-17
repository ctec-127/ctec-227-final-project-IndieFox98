<?php
    require_once "inc/new_mysqli.php";

    $img_id = $_GET['image_id'];

    $sql = "DELETE FROM image WHERE image_id = '" . $img_id . "'";

    $result = $db->query($sql);

    header('location: index.php');
?>