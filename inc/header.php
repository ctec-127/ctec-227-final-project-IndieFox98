<!-- Header include file -->

<header>
    <div id="heading">
        <div id="logo"><a href="index.php"><img src="img/imgload-logo.png"></a></div>
    </div>
    <nav>
        <div><a class="headerlink" href="about.php">about</a></div>
        <?= isset($_SESSION['login']) ?
        '<div><a class="headerlink" href="submit.php">submit</a></div>' :
        '<div><a class="headerlink" href="register.php">register</a></div>'; ?>
        <?= isset($_SESSION['login']) ?
        '<div><a class="headerlink" href="logout.php">logout</a></div>' :
        '<div><a class="headerlink" href="login.php">login</a></div>'; ?>
    </nav>
</header>