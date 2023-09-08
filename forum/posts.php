<?php
require '../functions.php';
if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Member Area</title>
</head>

<body class="clan-longue-body">

    <header>
        <div>
            <?php
            global $conn;
            $id = $_GET["clan_id"];
            $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
            ($rows = mysqli_fetch_assoc($fconn));
            $cat_name = $rows['cat_name'];
            echo '<p> Welcome to ' . $cat_name . ' Longue</p>';

            ?>
        </div>
    </header>
    <section class="clan-forum-container">
        <!-- section news -->
        <div class="clan-forum-category"> 
            <div class="clan-forum-icons">
                <div><img src="../icon.png" alt=""></div>
                <div class="cat-descr">
                    <?php
                    global $conn;
                    $id = $_GET["clan_id"];
                    $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                    ($rows = mysqli_fetch_assoc($fconn));
                    $cat_name = $rows['cat_name'];
                    echo '<a href="news.php?clan=' . $cat_name . '&cat=news"> ' . $cat_name . ' News</a>';
                    ?>
                    <p>Get the latest news from your clan</p>
                </div>
            </div>
            <div class="clan-forum-total-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $fconn = mysqli_query($conn, "SELECT * FROM news WHERE news_for = '$clan'");
                $total = mysqli_num_rows($fconn);
                echo '<p>' . $total . ' posts</p>';
                ?>
            </div>
            <div class="clan-forum-latest-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $latest = mysqli_query($conn, "SELECT * FROM news WHERE news_for = '$clan' ORDER BY news_id DESC");
                $row_latest = mysqli_fetch_assoc($latest);
                $lattestnews = $row_latest['news_id'];
                $latesttitle = $row_latest['news_title'];
                $latestauthor = $row_latest['news_by'];
                $latestdate = $row_latest['news_date'];
                
                echo '<a href="topic.php?post='.$lattestnews.'&clan='.$clan.'&cat=news">' . $latesttitle . '</a>
                    <p> ' . $latestauthor . '</p>
                    <p>' . $latestdate . '</p>';
                ?>
            </div>
        </div>

        
        <!-- section events -->
        <div class="clan-forum-category">
            <div class="clan-forum-icons">
                <div><img src="../icon.png" alt=""></div>
                <div class="cat-descr">
                    <?php 
                    global $conn;
                    $id = $_GET["clan_id"];
                    $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                    ($rows = mysqli_fetch_assoc($fconn));
                    $cat_name = $rows['cat_name'];
                    echo '<a href="events.php?clan=' . $cat_name . '&cat=events"> ' . $cat_name . ' Events</a>';
                    ?>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a?</p>
                </div>
            </div>
            <div class="clan-forum-total-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $fconn = mysqli_query($conn, "SELECT * FROM events WHERE clan_events = '$clan'");
                $total = mysqli_num_rows($fconn);
                echo '<p>' . $total . ' posts</p>';
                ?>
            </div>
            <div class="clan-forum-latest-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $latest = mysqli_query($conn, "SELECT * FROM events WHERE clan_events = '$clan' ORDER BY events_id DESC");
                $row_latest = mysqli_fetch_assoc($latest);
                $latesteventid = $row_latest['events_id'];
                $latesttitle = $row_latest['events_title'];
                $latestauthor = $row_latest['posted_by'];
                $latestdate = $row_latest['events_date'];
                echo '<a href="topic.php?post='.$latesteventid.'&clan='.$clan.'&cat=events">' . $latesttitle . '</a>
                    <p> ' . $latestauthor . '</p>
                    <p>' . $latestdate . '</p>';
                ?>
            </div>
        </div>


        <!-- section guides -->
        <div class="clan-forum-category">
            <div class="clan-forum-icons">
                <div><img src="../icon.png" alt=""></div>
                <div class="cat-descr">
                    <?php
                    global $conn;
                    $name = $_GET["clan_id"];
                    $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $name");
                    ($rows = mysqli_fetch_assoc($fconn));
                    $cat_name = $rows['cat_name'];
                    echo '<a href="guides.php?clan=' . $cat_name . '&cat=guides"> ' . $cat_name . ' Guides</a>';
                    ?>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a? Abu</p>
                </div>
            </div>
            <div class="clan-forum-total-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $fconn = mysqli_query($conn, "SELECT * FROM guides WHERE guide_for = '$clan'");
                $total = mysqli_num_rows($fconn);
                echo '<p>' . $total . ' posts</p>';
                ?>
            </div>
            <div class="clan-forum-latest-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $latest = mysqli_query($conn, "SELECT * FROM guides WHERE guide_for = '$clan' ORDER BY `guides_id` DESC");
                $row_latest = mysqli_fetch_assoc($latest);
                $lattestguide = $row_latest['guides_id'];
                $latesttitle = $row_latest['guides_title'];
                $latestauthor = $row_latest['guides_by'];
                $latestdate = $row_latest['guides_date'];
                echo '<a href="topic.php?post='.$lattestguide.'&clan='.$clan.'&cat=guides">' . $latesttitle . '</a>
                    <p> ' . $latestauthor . '</p>
                    <p>' . $latestdate . '</p>';
                ?>
            </div>
        </div>


        <!-- section post your stats -->
        <div class="clan-forum-category">
            <div class="clan-forum-icons">
                <div><img src="../icon.png" alt=""></div>
                <div class="cat-descr">
                    <?php
                    global $conn;
                    $id = $_GET["clan_id"];
                    $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                    ($rows = mysqli_fetch_assoc($fconn));
                    $cat_name = $rows['cat_name'];
                    echo '<a href="post-your-stats.php?clan=' . $cat_name . '&cat=character"> Post Your ' . $cat_name . ' Stats</a>';
                    ?>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, a?</p>
                </div>
            </div>
            <div class="clan-forum-total-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $fconn = mysqli_query($conn, "SELECT * FROM showoff WHERE clan = '$clan'");
                $total = mysqli_num_rows($fconn);
                echo '<p>' . $total . ' posts</p>';
                ?>
            </div>
            <div class="clan-forum-latest-post">
                <?php
                global $conn;
                $id = $_GET["clan_id"];
                $fconn2 = mysqli_query($conn, "SELECT * FROM category WHERE cat_id = $id");
                $rows = mysqli_fetch_assoc($fconn2);
                $clan = $rows['cat_name'];
                $latest = mysqli_query($conn, "SELECT * FROM showoff WHERE clan = '$clan' ORDER BY `pys_id` DESC");
                $row_latest = mysqli_fetch_assoc($latest);
                $lattestpys = $row_latest['pys_id'];
                $latesttitle = $row_latest['pys_title'];
                $latestauthor = $row_latest['pys_by'];
                $latestdate = $row_latest['pys_date'];
                echo '<a href="topic.php?post='.$lattestpys.'&clan='.$clan.'&cat=character">' . $latesttitle . '</a>
                    <p> ' . $latestauthor . '</p>
                    <p>' . $latestdate . '</p>';
                ?>

            </div>
        </div>
        <div class="forum-back-btn">
            <a href="./longue.php">Back</a>
        </div>
    </section>

</body>

</html>