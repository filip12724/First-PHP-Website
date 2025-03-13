<?php


include_once("Methods/conn.php");
global $conn;
$upit = "SELECT * FROM nav_meni";
$nav_meni = $conn->query($upit)->fetchAll();


if (isset($_SESSION['user'])) {
    $loginText = "Log Out";
    $loginLink = "logout.php";
} else {
    $loginText = "Log In";
    $loginLink = "log-in.php";
}


foreach ($nav_meni as $nav) {
    if ($nav->nav_name == "Log In") {
        $nav->nav_name = $loginText;
        $nav->nav_path = $loginLink;
    }
}
?>
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo.png" alt="" style="width: 158px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <?php if(isset($_SESSION['user'])):
                            $user=$_SESSION['user'];

                         ?>
                        <?php if($user->role=="admin"): ?>
                            <li><a href="admin-panel.php">Admin panel</a></li>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php foreach ($nav_meni as $nav): ?>

                        <li><a href="<?=$nav->nav_path?>" <?php if(basename($_SERVER['PHP_SELF']) == "$nav->nav_path") echo 'class="active"'; ?>><?=$nav->nav_name?></a></li>
                      <?php endforeach; ?>

                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
