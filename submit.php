<!-- Image submission page -->

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
    <title>imgload - Time to submit!</title>
</head>
<body>
    <main>
        <?php require_once "inc/header.php"; ?>
        <article>
            <?php if (isset($_SESSION['login'])) { ?>
            <h1>Get ready to submit!</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div>
                    <input id="image" name="image" type="file" accept="image/jpeg, image/png, image/gif">
                </div>
                <div>
                    <label for="title">Title</label>
                    <input id="title" name="title" type="text">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="9" cols="53"></textarea>
                </div>
                <div>
                    <label for="alt">Alt Text</label>
                    <input id="alt" name="alt" type="text">
                </div>
                <input class="button" type="submit" value="SUBMIT!">
                <input class="button" type="reset" value="RESET">
            </form>
            <?php } else { ?>
            <p>You don't exist. Go away!</p>
            <?php } ?>
        </article>
        <aside>
        </aside>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>