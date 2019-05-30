<!-- Login page -->

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
        <h1>You gotta log in in order to load images!</h1>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password">
            </div>
            <input type="submit" value="Log In!">
        </form>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>