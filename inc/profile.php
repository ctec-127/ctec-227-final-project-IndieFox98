<!-- Profile include file -->

<?php if (isset($_SESSION['login'])) { ?>
<div class="profile">
    <img src="<?= isset($_SESSION['login']) && !empty($_SESSION['propic']) ? 'imgloads/' . $_SESSION['propic'] : 'img/default-propic.png'; ?>">
    <h1><?= isset($_SESSION['login']) ? $_SESSION['first'] . ' ' . $_SESSION['last'] : ''; ?></h1>
    <p><?= isset($_SESSION['login']) ? $_SESSION['alias'] : ''; ?></p>
    <a href="edit_profile.php" class="profile-link">EDIT</a>
</div>
<?php } else { ?>
<button>REGISTER</button>
<?php } ?>