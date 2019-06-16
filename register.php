<!-- Register page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    $success = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required = ['first', 'last', 'alias', 'email', 'password', 'confirm'];

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
            echo '<div>Error! Error! Run with terror! A field is missing!</div>';
        } else if (!$confirm) {
            echo '<div>Yo, yo password cannot be confirmed, man.</div>';
        } else {
            $fname = $db->real_escape_string($_POST['first']);
            $lname = $db->real_escape_string($_POST['last']);
            $alias = $db->real_escape_string($_POST['alias']);
            $email = $db->real_escape_string($_POST['email']);
            $pword = hash('sha512', $_POST['password']);
            $date = $db->real_escape_string(date("Y/m/d"));

            $sql = "INSERT INTO user (first_name, last_name, user_name, role, email, password, join_date) 
                    VALUES ('$fname', '$lname', '$alias', 'member', '$email', '$pword', '$date')";

            $result = $db->query($sql);

            if ($db->error) {
                echo '<div>' . $db->error . '</div>';
            } else {
                echo '<div>Congratulations! You made an account!</div>';
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
            } else { ?>
            <h1>You gotta register in order to log in!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="first">First Name</label>
                    <input id="first" name="first" type="text" value="<?= isset($_POST['first']) ? $_POST['first'] : ''; ?>">
                </div>
                <div>
                    <label for="last">Last Name</label>
                    <input id="last" name="last" type="text" value="<?= isset($_POST['last']) ? $_POST['last'] : ''; ?>">
                </div>
                <div>
                    <label for="alias">Username</label>
                    <input id="alias" name="alias" type="text" value="<?= isset($_POST['alias']) ? $_POST['alias'] : ''; ?>">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                </div>
                <div>
                    <label for="confirm">Confirm Password</label>
                    <input id="confirm" name="confirm" type="password">
                </div>
                <input class="button" type="submit" value="REGISTER!">
                <input class="button" type="reset" value="RESET">
            </form>
            <?php } ?>
        </article>
        <aside>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>