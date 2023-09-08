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
    <title>News</title>
</head>

<?php
global $conn;
$sec = $_GET["cat"];
$status = $_SESSION["gm"];
$method = $_SERVER["REQUEST_METHOD"];
if ($method == 'POST') {
    $user = $_SESSION["user_name"];
   
    $clan = $_GET["clan"];
    $title = htmlspecialchars($_POST["news-title"]);
    $desc = $_POST["news-content"];
    if (empty($title) || empty($desc)) {
        echo "<script>
        alert('Oops some of the field is empty!');
        document.location.href = '';
        </script>";
    } else {
        if (strlen($desc) > 6000 || strlen($title) > 50) {
            echo "<script>
            alert('Oops too many characters!');
            document.location.href = '';
            </script>";
        } else {
            mysqli_query($conn, "INSERT INTO news VALUES('','$title','$desc', current_timestamp(), '$user','$clan','$sec')");

            echo "<script>
         alert('Post created!');
         document.location.href = '';
         </script>";
        }
    }
}
?>



<?php
global $conn;
$clan = $_GET['clan'];
$sec = $_GET["cat"];
$rowdataonpage = 7;
$selecttable = mysqli_query($conn, "SELECT * FROM news WHERE news_for = '$clan' ORDER BY `news_id` DESC ");
$totalrow = mysqli_num_rows($selecttable);
$totalpages = ceil($totalrow / $rowdataonpage);
if (isset($_GET["page"])) {
    $activepage = $_GET["page"];
} else {
    $activepage = 1;
};
$firstpage = ($rowdataonpage *  ($activepage)) - $rowdataonpage;
echo '<body class="clan-guides-body" style="background-image: url(' . $clan . '.webp);">';
?>
<div class="guides-frame">
    <section class="guide-content">
        <div class="clan-guides-list" id="clan-guide-list">
            <?php
            global $conn;
            
            $fconn = mysqli_query($conn, "SELECT * FROM news WHERE news_for = '$clan' ORDER BY `news_id` DESC LIMIT $firstpage, $rowdataonpage");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $news_title = $rows['news_title'];
                $posted = $rows['news_by'];
                $date = $rows['news_date'];
                $newsid = $rows['news_id'];
                $section = $rows['section'];
                echo '<a href="topic.php?post=' . $newsid . '&clan='.$clan.'&cat='.$section.'"> ' . $news_title . ' </a>';

               
                echo '<p>By : ' . $posted . ', ' . $date . ' </p>';
            }
            ?>
        </div>
        <div class="num-page">
            <?php
            for ($i = 1; $i <= $totalpages; $i++) {
                echo '<a href="news.php?clan=' . $clan . '&cat=news&page=' . $i . '">' . $i . '</a>';
                
            }
            ?>
        </div>
        <div class="current-page">
            <?php
            echo '<p>Current page:  ' . $activepage . '</p>'
            ?>
        </div>
        <div class="toggle-guides-form">
            <?php 
            if (($_SESSION["gm"])){
                echo '<button id="toggle-guides-form">Create Post</button>';
            }?>
        
            <div id="btn_back_news">
                <?php
                global $conn;
                $as = $_GET['clan'];
                $fconn = mysqli_query($conn, "SELECT * FROM category WHERE cat_name = '$as'");
                $row = mysqli_fetch_assoc($fconn);
                $name = $row['cat_id'];
                echo '<a href="posts.php?clan_id=' . $name . '">Back</a>'; ?>
            </div>
        </div>
    </section>
    <section class="guides-form-content">
        <div class="guides-body-form-content">
            <div>
                <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                    <div class="guides-form">
                        <label for="guides-title">News</label> 
                        <input type="text" name="news-title" id="guides-title" placeholder="enter title" maxlength="50" required>
                        <textarea name="news-content" id="post_desc" maxlength="6000" required></textarea>
                        <button type="submit" name="news-post">Post</button>
                        <input type="button" value="New Line" id="pcomment_nl">
                        <input type="button" value="Insert Image" id="pcomment_insertimg">
                        <input type="button" id="guides-cancel-btn" value="Cancel">
                    </div>
                </form>
               
            </div>

        </div>

    </section>



</div>

<div class="home-btn-all">
    <a href="../index.php">Home</a>
</div>
<div class="dashboard-btn-all">
    <?php
    if ($_SESSION["member"]) {
        echo '<a href="../member/member.php">Dashboard</a>';
    } else {
        echo '<a href="../admin/admindashboard.php">Dashboard</a>';
    }
    ?>

</div>
<script src="post3.js"></script>
</body>

</html>