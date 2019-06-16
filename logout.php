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
    <?php require_once "inc/head.html"?>
    <title>imgload - See you later!</title>
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