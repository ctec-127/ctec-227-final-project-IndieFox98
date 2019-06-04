<!-- Home page -->

<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>imgload - An image load of galleries!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <h1>Welcome, <?= isset($_SESSION['fname']) && isset($_SESSION['lname']) ? $_SESSION['fname'] . ' ' . $_SESSION['lname'] : 'stranger'; ?>!</h1>
        </article>
        <aside>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>