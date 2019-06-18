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
        $required = ['title', 'description', 'alt', 'category', 'tags'];

        $error = false;
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            $msg = 'Please fill in the missing fields.';
        } else {
            $tmp_file = $_FILES['image']['tmp_name'];  # Temporary image file name
            $title = $db->real_escape_string($_POST['title']);
            $description = $db->real_escape_string($_POST['description']);
            $alt = $db->real_escape_string($_POST['alt']);
            $category = $db->real_escape_string($_POST['category']);
            $tags = $db->real_escape_string($_POST['tags']);
            $id = $db->real_escape_string($_SESSION['id']);
            $date = $db->real_escape_string(date("Y/m/d"));

            $tags = str_replace(' ', '', $tags);
            $tag_array = explode(',', $tags);

            $target_file = $_SESSION['id'] . '_' . basename($_FILES['image']['name']); # Actual file name
            $file_size = $_FILES['image']['size'];

            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            // if (file_exists($upload_dir . '/' . $target_file)) {
            //     $target_file = $_SESSION['id'] . '_' . $target_file;
            // }

            if (($file_ext == 'png' || $file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'gif') || empty($tmp_file)) {
                if (move_uploaded_file($tmp_file, $upload_dir . '/' . $target_file)) { # Check if the selected image has been moved to the destination folder
                    $msg = "Upload successful!";
                    // $msg_class = "success";

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

                    # Now add image tags
                    foreach ($tag_array as $tag) {
                        # Add tag to database if it doesn't exist
                        $sql_tag = "SELECT * FROM tag";

                        $result = $db->query($sql_tag);

                        $empty = true;
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['tag_name'] == $tag) {
                                $empty = false;
                            }
                        }

                        if ($empty) {
                            $sql_addtag = "INSERT INTO tag (tag_name) 
                                        VALUES ('$tag')";

                            $result = $db->query($sql_addtag);
                        }

                        $sql_latestimg = "SELECT image_id 
                                        FROM image 
                                        ORDER BY image_id DESC LIMIT 1";

                        $result = $db->query($sql_latestimg);
                        $row = $result->fetch_assoc();
                        $image_id = $row['image_id'];

                        $sql_selecttag = "SELECT tag_id 
                                        FROM tag 
                                        WHERE tag_name = '$tag'";

                        $result = $db->query($sql_selecttag);
                        $row = $result->fetch_assoc();
                        $tag_id = $row['tag_id'];

                        $sql_addimgtag = "INSERT INTO image_tag (image_id, tag_id) 
                                            VALUES ('$image_id', '$tag_id')";

                        $result = $db->query($sql_addimgtag);
                    }
                } else {
                    $err = $_FILES['image']['error'];
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
    <title>imgload - Time to submit!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <h1>Get ready to submit!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="message<?= isset($msg) ? '' : '-hidden'; ?>"><?= isset($msg) ? $msg : ''; ?></div>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                    <label for="image">Image *</label>
                    <input id="image" name="image" <?= $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['image']['error']) ? 'class="missing"' : ''; ?> type="file" onfocus="this.className = ''" accept="image/jpeg, image/png, image/gif">
                </div>
                <div>
                    <label for="title">Title *</label>
                    <input id="title" name="title" <?= isset($_POST['title']) && empty($_POST['title']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['title']) ? $_POST['title'] : ''; ?>">
                </div>
                <div>
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" <?= isset($_POST['description']) && empty($_POST['description']) ? 'class="missing"' : ''; ?> onfocus="this.className = ''" rows="9" cols="53"><?= isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                </div>
                <div>
                    <label for="alt">Alt Text *</label>
                    <input id="alt" name="alt" <?= isset($_POST['alt']) && empty($_POST['alt']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['alt']) ? $_POST['alt'] : ''; ?>">
                </div>
                <div>
                    <label for="category">Category *</label>
                    <!-- <input id="category" name="category" type="text" -->
                    <select id="category" name="category" <?= isset($_POST['category']) && empty($_POST['category']) ? 'class="missing"' : ''; ?> onfocus="this.className = ''">
                        <option value="">Please select...</option>
                        <option value="cgi" <?= isset($_POST['category']) && $_POST['category'] == 'cgi' ? 'selected' : ''; ?>>CGI</option>
                        <option value="comic" <?= isset($_POST['category']) && $_POST['category'] == 'comic' ? 'selected' : ''; ?>>Cartoons & Comics</option>
                        <option value="photo" <?= isset($_POST['category']) && $_POST['category'] == 'photo' ? 'selected' : ''; ?>>Photography</option>
                        <option value="humor" <?= isset($_POST['category']) && $_POST['category'] == 'humor' ? 'selected' : ''; ?>>Humor</option>
                    </select>
                </div>
                <div>
                    <label for="tags">Tags * (separate by commas)</label>
                    <input id="tags" name="tags" <?= isset($_POST['tags']) && empty($_POST['tags']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['tags']) ? $_POST['tags'] : ''; ?>">
                </div>
                <input class="form-button" type="submit" value="SUBMIT!">
                <input class="form-button" type="reset" value="RESET">
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
<script src="js/sticky-sidebar.js"></script>