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
        $tmp_file = $_FILES['propic']['tmp_name'];

        $target_file = basename($_FILES['propic']['name']);

        $file_ext = strtolower(pathinfo($_FILES['propic']['name'], PATHINFO_EXTENSION));

        if (($file_ext == 'png' || $file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'gif') || empty($tmp_file)) {
            if (move_uploaded_file($tmp_file, $upload_dir . '/' . $target_file)) { # Check if the selected image has been moved to the destination folder
                $msg = "Upload successful!";
                $msg_class = "success";

                # Add profile pic to database
                $sql = "UPDATE user SET profile_pic = '" . $target_file . "' WHERE user_id = '" . $_SESSION['id'] . "'";

                $result = $db->query($sql);
            } else {
                $err = $_FILES['propic']['error'];
                $msg = $upload_errors[$err];
                $msg_class = "alert";
            }
        } else {
            $msg = "Only png, jpg/jpeg, and gif files are allowed. This is an <strong>image</strong> uploader, genius.";
            $msg_class = "alert";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>imgload - Edit profile!</title>
</head>
<body>
    <?php if (!empty($msg)) {echo "<div>{$msg}</div>";} ?>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <h1>You mean to tell me you aren't who I think you are???</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="first">First Name</label>
                    <input id="first" name="first" type="text" value="<?= isset($_SESSION['first']) ? $_SESSION['first'] : ''; ?>">
                </div>
                <div>
                    <label for="last">Last Name</label>
                    <input id="last" name="last" type="text" value="<?= isset($_SESSION['last']) ? $_SESSION['last'] : ''; ?>">
                </div>
                <div>
                    <label for="alias">Username</label>
                    <input id="alias" name="alias" type="text" value="<?= isset($_SESSION['alias']) ? $_SESSION['alias'] : ''; ?>">
                </div>
            </form>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                    <label for="propic">Profile Picture</label>
                    <input id="propic" name="propic" type="file" accept="image/jpeg, image/png, image/gif">
                </div>
                <input class="button" type="submit" value="CHANGE!">
                <input class="button" type="reset" value="RESET">
            </form>
            <?php } else { ?>
            <p>You don't exist. Go away!</p>
            <?php } ?>
        </article>
        <aside>
            <?php require_once "inc/profile.php"; ?>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>