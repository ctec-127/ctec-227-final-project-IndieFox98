<!-- Register page -->

<?php
    require_once "inc/new_mysqli.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $db->real_escape_string($_POST['first']);
        $lname = $db->real_escape_string($_POST['last']);
        $alias = $db->real_escape_string($_POST['alias']);
        $email = $db->real_escape_string($_POST['email']);
        $pword = $db->real_escape_string($_POST['password']);
        $date = $db->real_escape_string(date("Y/m/d"));

        $sql = "INSERT INTO user (first_name, last_name, user_name, role, email, password, join_date)
                VALUES ('$fname', '$lname', '$alias', 'member', '$email', '$pword', '$date')";

        $result = $db->query($sql);
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
    <title>imgload - Let's register!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <h1>You gotta register in order to log in!</h1>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label for="first">First Name</label>
                <input id="first" name="first" type="text">
            </div>
            <div>
                <label for="last">Last Name</label>
                <input id="last" name="last" type="text">
            </div>
            <div>
                <label for="alias">Username</label>
                <input id="alias" name="alias" type="text">
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password">
            </div>
            <div>
                <label for="confirm">Confirm Password</label>
                <input id="confirm" type="password">
            </div>
            <input type="submit" value="Register!">
        </form>
    </main>
</body>
</html>