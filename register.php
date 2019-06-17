<!-- Register page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    $success = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['first', 'last', 'alias', 'email', 'dob', 'password', 'confirm'];

        $error = false;
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        $confirm = true;
        if (!empty($_POST['password']) && !empty($_POST['confirm'])) {
            if ($_POST['password'] != $_POST['confirm']) {
                $confirm = false;
            }
        }

        if ($error) {
            // echo '<div>Error! Error! Run with terror! A field is missing!</div>';
            $msg = 'Please fill in the following fields.';
        } else if (!$confirm) {
            // echo '<div>Yo, yo password cannot be confirmed, man.</div>';
            $msg = 'Password cannot be confirmed. Try again.';
        } else {
            $fname = $db->real_escape_string($_POST['first']);
            $lname = $db->real_escape_string($_POST['last']);
            $alias = $db->real_escape_string($_POST['alias']);
            $email = $db->real_escape_string($_POST['email']);
            $dob = $db->real_escape_string($_POST['dob']);
            $pword = hash('sha512', $_POST['password']);
            $date = $db->real_escape_string(date("Y/m/d"));

            $sql = "INSERT INTO user (first_name, last_name, user_name, birth_date, role, email, password, join_date) 
                    VALUES ('$fname', '$lname', '$alias', '$dob', 'member', '$email', '$pword', '$date')";

            $result = $db->query($sql);

            if ($db->error) {
                // echo '<div>' . $db->error . '</div>';
                $msg = $db->error;
            } else {
                $success = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "inc/head.html"?>
    <title>imgload - Let's register!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) {
                header("location: index.php");
            } else {
                if ($success) { ?>
            <h1>Thank you so much for registering!</h1>
            <?php } else { ?>
            <h1>You gotta register in order to log in!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="message<?= isset($msg) ? '' : '-hidden'; ?>"><?= isset($msg) ? $msg : ''; ?></div>
                <div>
                    <label for="first" title="This field is required.">First Name *</label>
                    <input id="first" name="first" <?= isset($_POST['first']) && empty($_POST['first']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['first']) ? $_POST['first'] : ''; ?>">
                </div>
                <div>
                    <label for="last" title="This field is required.">Last Name *</label>
                    <input id="last" name="last" <?= isset($_POST['last']) && empty($_POST['last']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['last']) ? $_POST['last'] : ''; ?>">
                </div>
                <div>
                    <label for="alias" title="This field is required.">Username *</label>
                    <input id="alias" name="alias" <?= isset($_POST['alias']) && empty($_POST['alias']) ? 'class="missing"' : ''; ?> type="text" onfocus="this.className = ''" value="<?= isset($_POST['alias']) ? $_POST['alias'] : ''; ?>">
                </div>
                <div>
                    <label for="email" title="This field is required.">Email *</label>
                    <input id="email" name="email" <?= isset($_POST['email']) && empty($_POST['email']) ? 'class="missing"' : ''; ?> type="email" onfocus="this.className = ''" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div>
                    <label for="dob" title="This field is required.">Date of Birth *</label>
                    <input id="dob" name="dob" <?= isset($_POST['dob']) && empty($_POST['dob']) ? 'class="missing"' : ''; ?> type="date" onfocus="this.className = ''" value="<?= isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
                </div>
                <div>
                    <label for="password" title="This field is required.">Password *</label>
                    <div class="pwd-area">
                        <input id="password" name="password" <?= isset($_POST['password']) && empty($_POST['password']) ? 'class="missing"' : ''; ?> type="password" onfocus="this.className = ''" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                        <span id="tgl-password" class="toggle-pwd" onclick="togglePassword('password')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <div>
                    <label for="confirm" title="This field is required.">Confirm Password *</label>
                    <div class="pwd-area">
                        <input id="confirm" name="confirm" <?= isset($_POST['confirm']) && empty($_POST['confirm']) ? 'class="missing"' : ''; ?> type="password" onfocus="this.className = ''">
                        <span id="tgl-confirm" class="toggle-pwd" onclick="togglePassword('confirm')"><i class="fa fa-eye"></i></span>
                    </div>
                </div>
                <input class="form-button" type="submit" value="REGISTER!">
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