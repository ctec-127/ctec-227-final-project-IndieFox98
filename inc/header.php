<!-- Header include file -->

<header>
    <div class="header-title">
        <a href="index.php"><img class="header-logo" src="img/imgload-logo.png" alt="The imgload logo."></a>
    </div>
    <nav>
        <div class="desktop-nav">
            <div><a class="header-link" href="about.php">about</a></div>
            <div>
                <?= isset($_SESSION['login']) ?
                '<a class="header-link" href="logout.php">logout</a>' :
                '<a class="header-link" href="login.php">login</a>'; ?>
            </div>
            <div>
                <?= isset($_SESSION['login']) ?
                '<a class="header-link" href="submit.php">submit</a>' :
                '<a class="header-link" href="register.php">register</a>'; ?>
            </div>
        </div>
        <div class="menu">
            <div class="menu-icon" onclick="dropMenu();"><i class="fa fa-bars"></i></div>
        </div>
    </nav>
    <div class="mobile-nav">
        <div class="header-link">about</div>
        <div class="header-link">login</div>
        <div class="header-link loud">register</div>
    </div>
</header>
<script src="js/mobile-menu.js"></script>