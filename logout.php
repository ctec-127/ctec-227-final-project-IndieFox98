<!-- Template page -->

<?php
    session_start();

    require_once "inc/new_mysqli.php";

    if (isset($_SESSION['login'])) {
        session_unset();
        session_destroy();
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
    <title>imgload - An image load of galleries!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <h1>You have been logged out. Come back soon!</h1>
        </article>
        <aside>
            <p>The quick brown fox jumped over the lazy dog.</p>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>