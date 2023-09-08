<?php

require 'functions.php';
// if (isset($_SESSION["login"]))
// header('Location: index.php')

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Your Game Name Here</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require 'form.php';
    require 'header.php';

    ?>

    <div class="home-content">
        <main>
            <div class="main-bg">
                <div class="bgimage">
                    <img src="home-bg.webp" alt="">
                </div>

                <article>
                    <div class="opening">
                        <h1>
                            Welcome to our game website! Let the gaming excitement begin!
                        </h1>
                        <h2>
                            Play with Other Players in This MMORPG
                        </h2>
                        <div class="main-screen-btn">
                            <div class="pencetanlogin2">
                                <button id="login-up" <?php echo ($_SESSION['login'] == 1) ? 'style="display:none;"' : '' ?> type="button"><img src="loginbtn.png" alt=""></button>
                                <a id="btn-signout" href="logout.php" <?php echo ($_SESSION['login'] == 1) ? 'style="display:block;"' : '' ?> type="button"><img src="logout.png" alt=""></a>
                            </div>
                            <div class="pencetandaftar2">
                                <button id="register-up" <?php echo ($_SESSION['login'] == 1) ? 'style="display:none;"' : '' ?> type="button"><img src="registerbtn.png" alt=""></button>
                            </div>
                        </div>
                    </div>

                </article>

                <div class="main-content">
                    <div class="news-head-text">
                        <h1>News</h1>

                    </div>
                    <div class="main-news">


                        <div class="news-bg-content">
                            <img src="bg-featured2.png" alt="">
                        </div>
                        <div class="news-main-content">
                            <img src="bg-featured-text-content.png" alt="">
                        </div>
                        <div class="news-list">
                            <a href="">News 1</a>
                            <a href="">News 2</a>
                            <a href="">News 3</a>
                            <a href="">News 4</a>

                        </div>

                    </div>

                    <div class="heroes">
                        <div class="races">
                            <h1>Clan</h1>
                        </div>
                        <div class="orchero">
                            <p>A formidable race of warriors known for their raw strength, unwavering determination, and tribal culture. They were once noble protectors but were corrupted by a cataclysmic event. Now, they roam the harsh lands, engaging in relentless warfare against rival tribes and other races.</p>
                            <img class="orcimage" src="orchero.png" alt="">
                            <img class="frame-bg" src="bg-featured2.png" alt="">
                            <img class="orc-emblem" src="orc-emblem.png" alt="">

                        </div>
                        <div class="humanhero">
                            <img class="humanimage" src="humanhero.png" alt="">
                            <img class="frame-bg" src="bg-featured2.png" alt="">
                            <div class="human-emblem"></div>
                            <p>Despite their diversity, Humans share common values of courage, ambition, and the pursuit of knowledge. They possess a remarkable capacity for adaptation, harnessing the forces of technology, magic, or sheer determination to overcome obstacles and shape the world around them.</p>
                        </div>
                        <div class="elfhero">
                            <p>With an exquisite beauty that surpasses that of any mortal race, Elves embody an ethereal charm and delicate features. Their societies are often steeped in rich traditions, artistry, and a deep reverence for nature. They are skilled in a variety of disciplines, ranging from archery and swordsmanship to arcane magic and craftsmanship.</p>
                            <img src="elfhero.png" alt="">
                            <img class="frame-bg" src="bg-featured2.png" alt="">
                            <div class="elf-emblem"></div>


                        </div>
                    </div>
                    <div class="feature-list">
                        <h1>Features</h1>
                    </div>

                    <div class="slider">
                        <div class="slideshow" id="slideshow">
                            <div class="slide">
                                <p>Duel with your longsworn enemy</p>
                                <img src="duel.webp" alt="Image 3">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, incidunt.Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, incidunt</p>
                            </div>
                            <div class="slide">
                                <p>Fluid Battle</p>
                                <img src="fluidbattle.webp" alt="Image 1">
                                <p>Lorem ipsum sdolor sit amet consectetur adipisicing elit. Nesciunt, incidunt.</p>
                            </div>
                            <div class="slide">
                                <p>Clan Wars</p>
                                <img src="clanwar.webp" alt="Image 2">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, incidunt.</p>
                            </div>
                            <div class="slide">
                                <p>Undead Attack!</p>
                                <img src="undeadattack.webp" alt="Image 4">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, incidunt.</p>
                            </div>
                            

                        </div>
                        <button class="slide-button prev-button" id="nextBtn">&lt;</button>
                        <button class="slide-button next-button" id="prevBtn">&gt;</button>
                    </div>

                </div>



            </div>
        </main>
        <footer>
             <div class="copyright">
                <p>&copy; 2023 Rahmatullah WSN</p>
            </div>
            <img src="bg-footer.jpg" alt="">
           
        </footer>
    </div>



    <script src="app.js"></script>
</body>

</html>