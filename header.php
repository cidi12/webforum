<?php


?>
<header class="nav-top-bg">
    <nav>
        <div class="navbar">
            <div class="nav-bg">
                <img src="navbar.png" alt="">
            </div>
            <div class="main-btn item-home">
                <a href="home.php">Home</a>
            </div>
            <div class="main-btn item-about">
                <a href="about.php">About us</a>
            </div>
            <div class="main-btn item-services">
                <a href="#">Services</a>
            </div>
            <div class="main-btn item-forum">
                <a href="forum/longue.php">Forum</a>
            </div>
            <div class="main-btn item-download">
                <a href="#">Download</a>
            </div>
            <div class="main-btn item-help">
                <a href="#">Help</a>
            </div>
            <div class="main-btn item-contact">
                <a href="#">Contact us</a>
            </div>
            <div class="main-btn item-logo">
                <a href="#"><img src="icon.png" alt="" ></a>
            </div>
            <div class="loginout">
                <a id="btn-signin" <?php echo ($_SESSION['login']) ? 'style="display:none;"' : '' ?>>Sign In</a>
                
            </div>
            <div class="dashboard">
            <a id="btn-signout" <?php if ($_SESSION["gm"]==1){
            echo  'href="admin/admindashboard.php"';
            } else {
            echo  'href="member/member.php"';
            }
           ?>  <?php echo ($_SESSION['login'] == 1) ? 'style="display:block;"' : '' ?>>Dashboard</a>


            </div>
        </div>
    </nav>
</header>
