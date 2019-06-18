<!-- Edit profile page -->

<?php
    session_start();
    
    require_once "inc/new_mysqli.php";
    
    $upload_dir = 'imgloads';

    $upload_errors = [
        UPLOAD_ERR_INI_SIZE => "File size is too large! Try again.",
        UPLOAD_ERR_FORM_SIZE => "File size is too large! Try again.",
        UPLOAD_ERR_PARTIAL => "File has apparently been partially uploaded. Try again.",
        UPLOAD_ERR_NO_FILE => "Could you please be a dear and select a file to upload? Thanks.",
        UPLOAD_ERR_NO_TMP_DIR => "Stupid programmer error: No .tmp folder.",
        UPLOAD_ERR_CANT_WRITE => "File cannot be written to the disk. Try again.",
        UPLOAD_ERR_EXTENSION => "Dammit! File has been stopped by a PHP extension!"
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['first', 'last', 'alias'];

        $error = false;
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            $msg = 'Please fill in the missing fields.';
        } else {
            $tmp_file = $_FILES['propic']['tmp_name'];
            $fname = $db->real_escape_string($_POST['first']);
            $lname = $db->real_escape_string($_POST['last']);
            $alias = $db->real_escape_string($_POST['alias']);

            $target_file = $_SESSION['id'] . '_' . basename($_FILES['propic']['name']);

            $file_ext = strtolower(pathinfo($_FILES['propic']['name'], PATHINFO_EXTENSION));

            if (($file_ext == 'png' || $file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'gif') || empty($tmp_file)) {
                if (move_uploaded_file($tmp_file, $upload_dir . '/' . $target_file)) { # Check if the selected image has been moved to the destination folder
                    $msg = "Profile edited!";
                    // $msg_class = "success";

                    # Add profile pic to database
                    $sql = "UPDATE user 
                            SET first_name = '" . $fname . "', 
                            last_name = '" . $lname . "', 
                            user_name = '" . $alias . "', 
                            profile_pic = '" . $target_file . "' 
                            WHERE user_id = '" . $_SESSION['id'] . "'";

                    $result = $db->query($sql);

                    # Update profile pic displayed
                    $sql = "SELECT first_name, last_name, user_name, profile_pic 
                            FROM user 
                            WHERE user_id = '" . $_SESSION['id'] . "' LIMIT 1";

                    $result = $db->query($sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['first'] = $row['first_name'];
                        $_SESSION['last'] = $row['last_name'];
                        $_SESSION['alias'] = $row['user_name'];
                        $_SESSION['propic'] = $row['profile_pic'];
                    }
                } else {
                    $err = $_FILES['propic']['error'];
                    $msg = $upload_errors[$err];
                    // $msg_class = "alert";
                }
            } else {
                $msg = "Only png, jpg/jpeg, and gif files are allowed. This is an <strong>image</strong> uploader, genius.";
                // $msg_class = "alert";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "inc/head.html"?>
    <title>imgload - Edit profile!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <h1>You mean to tell me you aren't who I think you are???</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="message<?= isset($msg) ? '' : '-hidden'; ?>"><?= isset($msg) ? $msg : ''; ?></div>
                <div>
                    <label for="first" title="This field is required.">First Name *</label>
                    <input id="first" name="first" <?= isset($_POST['first']) && empty($_POST['first']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['first']) ? $_POST['first'] : $_SESSION['first']; ?>">
                </div>
                <div>
                    <label for="last" title="This field is required.">Last Name *</label>
                    <input id="last" name="last" <?= isset($_POST['last']) && empty($_POST['last']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['last']) ? $_POST['last'] : $_SESSION['last']; ?>">
                </div>
                <div>
                    <label for="alias" title="This field is required.">Username *</label>
                    <input id="alias" name="alias" <?= isset($_POST['alias']) && empty($_POST['alias']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['alias']) ? $_POST['alias'] : $_SESSION['alias']; ?>">
                </div>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                    <label for="propic">Profile Picture *</label>
                    <input id="propic" name="propic" <?= $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['propic']['error']) ? 'class="missing"' : ''; ?> type="file" onfocus="this.className = ''" accept="image/jpeg, image/png, image/gif">
                </div>
                <input class="form-button" type="submit" value="CHANGE!">
                <input class="form-button" type="reset" value="RESET">
            </form>
            <?php } else {
                header("location: login.php");
            } ?>
        </article>
        <aside>
            <?php require_once "inc/profile.php"; ?>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>
<script src="js/sticky-sidebar.js"></script>