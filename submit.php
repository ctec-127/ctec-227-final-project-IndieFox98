<!-- Image submission page -->

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
        $tmp_file = $_FILES['image']['tmp_name'];  # Temporary image file name
        $title = $db->real_escape_string($_POST['title']);
        $description = $db->real_escape_string($_POST['description']);
        $alt = $db->real_escape_string($_POST['alt']);
        $category = $db->real_escape_string($_POST['category']);
        $id = $db->real_escape_string($_SESSION['id']);
        $date = $db->real_escape_string(date("Y/m/d"));

        $target_file = $_SESSION['id'] . '_' . basename($_FILES['image']['name']); # Actual file name
        $file_size = $_FILES['image']['size'];

        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        // if (file_exists($upload_dir . '/' . $target_file)) {
        //     $target_file = $_SESSION['id'] . '_' . $target_file;
        // }

        if (($file_ext == 'png' || $file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'gif') || empty($tmp_file)) {
            if (move_uploaded_file($tmp_file, $upload_dir . '/' . $target_file)) { # Check if the selected image has been moved to the destination folder
                $msg = "Upload successful!";
                $msg_class = "success";

                # Add category to database if it doesn't exist
                $sql_category = "SELECT * FROM category";

                $result = $db->query($sql_category);

                $empty = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['category_name'] == $category) {
                        $empty = false;
                    }
                }

                if ($empty) {
                    $sql_addcat = "INSERT INTO category (category_name) 
                                    VALUES ('$category')";
                    
                    $result = $db->query($sql_addcat);
                }

                # Add profile pic to database
                $sql_category = "SELECT * FROM category WHERE category_name = '$category'";

                $result = $db->query($sql_category);
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];

                $sql_img = "INSERT INTO image (file_name, file_size, title, description, alt_text, user_id, category_id, image_date)
                            VALUES ('$target_file', '$file_size', '$title', '$description', '$alt', '$id', '$category_id', '$date')";

                $result = $db->query($sql_img);
            } else {
                $err = $_FILES['image']['error'];
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
    <?php require_once "inc/head.html"?>
    <title>imgload - Time to submit!</title>
</head>
<body>
    <?php if (!empty($msg)) {echo "<div>{$msg}</div>";} ?>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <h1>Get ready to submit!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                    <label for="image">Image</label>
                    <input id="image" name="image" type="file" accept="image/jpeg, image/png, image/gif">
                </div>
                <div>
                    <label for="title">Title</label>
                    <input id="title" name="title" type="text">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="9" cols="53"></textarea>
                </div>
                <div>
                    <label for="alt">Alt Text</label>
                    <input id="alt" name="alt" type="text">
                </div>
                <div>
                    <label for="category">Category</label>
                    <input id="category" name="category" type="text">
                </div>
                <input class="button" type="submit" value="SUBMIT!">
                <input class="button" type="reset" value="RESET">
            </form>
            <?php } else {
                header("location: index.php");
            } ?>
        </article>
        <aside>
            <?php require_once "inc/profile.php"; ?>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>