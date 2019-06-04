<!-- Login page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    function login($db) {
        $email = $db->real_escape_string($_POST['email']);
        $pword = $db->real_escape_string($_POST['password']);

        $sql = "SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . $pword . "' LIMIT 1";

        $result = $db->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['fname'] = $row['first_name'];
            $_SESSION['lname'] = $row['last_name'];
            $_SESSION['alias'] = $row['user_name'];
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
            echo '<div>Ay caramba! A blank field!</div>';
        } else {
            $attempt = login($db);

            if ($attempt) {
                echo '<div>You are now logged in. Welcome aboard.</div>';
                $success = true;
            } else {
                echo '<div>Incompatible login information. Try again, maggot.</div>';
            }
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
    <title>imgload - Let's log in!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) {
                header("location: index.php");
            } else { ?>
            <h1>You gotta log in if you wanna load images!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password">
                </div>
                <input class="button" type="submit" value="LOG IN!">
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