<!-- Login page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    function login($db) {
        $email = $db->real_escape_string($_POST['email']);
        $pword = hash('sha512', $_POST['password']);

        $sql = "SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . $pword . "' LIMIT 1";

        $result = $db->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['first'] = $row['first_name'];
            $_SESSION['last'] = $row['last_name'];
            $_SESSION['alias'] = $row['user_name'];
            $_SESSION['propic'] = $row['profile_pic'];
            $_SESSION['login'] = 1;
            header("location: index.php");
        } else {
            return false;
        }
    }

    $success = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['email', 'password'];

        $error = false;
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            // echo '<div>Ay caramba! A blank field!</div>';
            $msg = 'Please enter your credentials.';
        } else {
            $attempt = login($db);

            if ($attempt) {
                // echo '<div>You are now logged in. Welcome aboard.</div>';
                $success = true;
            } else {
                // echo '<div>Incompatible login information. Try again, maggot.</div>';
                $msg = 'Incorrect email or password. Try again.';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "inc/head.html"?>
    <title>imgload - Let's log in!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) {
                header("location: index.php");
            } else {
                if ($success) { ?>
            <h1>Thank you so much for logging in!</h1>
            <?php } else { ?>
            <h1>You gotta log in if you wanna load images!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="message<?= isset($msg) ? '' : '-hidden'; ?>"><?= isset($msg) ? $msg : ''; ?></div>
                <div>
                    <label for="email" title="This field is required.">Email *</label>
                    <input id="email" name="email" <?= isset($_POST['email']) && empty($_POST['email']) ? 'class="missing"' : ''; ?> type="email" onfocus="this.className = ''" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div>
                    <label for="password" title="This field is required.">Password *</label>
                    <div class="pwd-area">
                        <input id="password" name="password" <?= isset($_POST['password']) && empty($_POST['password']) ? 'class="missing"' : ''; ?> type="password" onfocus="this.className = ''" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                        <span id="tgl-password" class="toggle-pwd" onclick="togglePassword('password')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <input class="form-button" type="submit" value="LOG IN!">
                <input class="form-button" type="reset" value="RESET">
            </form>
            <?php }} ?>
        </article>
        <aside>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>
<script src="js/show-password.js"></script>
<script src="js/sticky-sidebar.js"></script>