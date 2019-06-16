<!-- About page -->

<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "inc/head.html"?>
    <title>imgload - About Us</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <h1>About imgload</h1>
            <p>Imgload is a site dedicated to image gallery building. It has been started by some college-attending freeloader named Torin Tashima so he can become immortal in the web development workplace.</p>
        </article>
        <aside>
            <?php require_once "inc/profile.php"; ?>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>