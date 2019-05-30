<!-- Image submission page -->

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
                <input id="description" name="description" type="text">
            </div>
            <div>
                <label for="alt">Alt Text</label>
                <input id="alt" name="alt" type="text">
            </div>
            <input type="submit" value="Submit!">
        </form>
        <?php require_once "inc/footer.php"; ?>
    </main>
</body>
</html>