<!-- Change password page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['old', 'new', 'confirm'];

        $error = false;
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        $confirm = true;
        if (!empty($_POST['new']) && !empty($_POST['confirm'])) {
            if ($_POST['new'] != $_POST['confirm']) {
                $confirm = false;
            }
        }

        $match = false;
        if (!empty($_POST['old'])) {
            $old = hash('sha512', $_POST['old']);

            $sql = "SELECT password FROM user WHERE user_id = '" . $_SESSION['id'] . "' LIMIT 1";

            $result = $db->query($sql);

            $row = $result->fetch_assoc();

            if ($row['password'] == $old) {
                $match = true;
            }
        }

        if ($error) {
            echo '<div>Ay caramba! A blank field!</div>';
        } else if (!$match) {
            echo '<div>That was not your old password...</div>';
        } else if (!$confirm) {
            echo '<div>Yo, yo password cannot be confirmed, man.</div>';
        } else {
            $old = hash('sha512', $_POST['old']);
            $new = hash('sha512', $_POST['new']);
            $confirm = hash('sha512', $_POST['confirm']);
    
            $sql = "UPDATE user SET password = '" . $new . "' WHERE user_id = '" . $_SESSION['id'] . "' LIMIT 1";
    
            $result = $db->query($sql);
    
            if ($db->error) {
                echo '<div>' . $db->error . '</div>';
            } else {
                echo '<div>Congratulations! You changed your undie--password!</div>';
                $success = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "inc/head.html"?>
    <title>imgload - Time to change your underwear, I mean, password!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="old">Old Password</label>
                    <div class="pwd-area">
                        <input id="old" name="old" class="pwd-field" type="password">
                        <span id="tgl-old" class="toggle-pwd" onclick="togglePassword('old')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <div>
                    <label for="new">New Password</label>
                    <div class="pwd-area">
                        <input id="new" name="new" class="pwd-field" type="password">
                        <span id="tgl-new" class="toggle-pwd" onclick="togglePassword('new')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <div>
                    <label for="confirm">Confirm Password</label>
                    <div class="pwd-area">
                        <input id="confirm" name="confirm" class="pwd-field" type="password">
                        <span id="tgl-confirm" class="toggle-pwd" onclick="togglePassword('confirm')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <input class="form-button" type="submit" value="CHANGE!">
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