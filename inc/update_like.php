<?php
    session_start();

    require_once "new_mysqli.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        # Check if reaction from user already exists
        $sql_reaction = "SELECT * 
                        FROM image_reaction 
                        WHERE image_id = '" . $_POST['img_id'] . "' AND user_id = '" . $_SESSION['id'] . "' LIMIT 1";

        $result_check = $db->query($sql_reaction);

        if ($result_check->num_rows == 1) {
            # Simply update database if reaction does exist
            $row = $result_check->fetch_assoc();

            if ($row['reaction_id'] != $_POST['reaction_id']) {
                $sql_update = "UPDATE image_reaction 
                                SET reaction_id = '" . $_POST['reaction_id'] . "' 
                                WHERE image_id = '" . $_POST['img_id'] . "' AND user_id = '" . $_SESSION['id'] . "' LIMIT 1";

                $result = $db->query($sql_update);
            }
        } else {
            # Insert if reaction from user doesn't exist
            $sql_insert = "INSERT INTO image_reaction (image_id, reaction_id, user_id) 
                            VALUES ('" . $_POST['img_id'] . "', '" . $_POST['reaction_id'] . "', '" . $_SESSION['id'] . "')";

            $result = $db->query($sql_insert);
        }
    } else {
        header("location: ../index.php");
    }
?>