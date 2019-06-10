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
            <h1>Welcome, <?= isset($_SESSION['login']) ? $_SESSION['first'] . ' ' . $_SESSION['last'] : 'stranger'; ?>!</h1>
            <?php require_once "inc/display_gallery.php"; ?>
        </article>
        <aside>
            <?php require_once "inc/profile.php"; ?>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>