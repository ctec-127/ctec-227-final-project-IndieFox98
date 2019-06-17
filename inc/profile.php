<!-- Profile include file -->

<div class="profile">
    <img src="<?= isset($_SESSION['login']) ? 'imgloads/' . $_SESSION['propic'] : 'img/default-propic.png'; ?>">
    <h1><?= isset($_SESSION['login']) ? $_SESSION['first'] . ' ' . $_SESSION['last'] : ''; ?></h1>
    <p><?= isset($_SESSION['login']) ? $_SESSION['alias'] : ''; ?></p>
    <a href="edit_profile.php">EDIT</a>
</div>