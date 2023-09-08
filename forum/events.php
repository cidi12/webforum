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
    <title>Events</title>
</head>

<?php
global $conn;
$sec = $_GET["cat"];
$status = $_SESSION["gm"];
$method = $_SERVER["REQUEST_METHOD"];
if ($method == 'POST') {
    $user = $_SESSION["user_name"];
   
    $clan = $_GET["clan"];
    $title = htmlspecialchars($_POST["event-title"]);
    $desc = $_POST["event-content"];
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
            mysqli_query($conn, "INSERT INTO events VALUES('','$title','$desc', current_timestamp(), '$clan','$user','$sec')");

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
echo '<body class="clan-guides-body" style="background-image: url(' . $clan . '.webp);">';
?>
<div class="guides-frame">
    <section class="guide-content">
        <div class="clan-guides-list" id="clan-guide-list">
            <?php
            global $conn;
            $clan = $_GET['clan'];
            $rowdataonpage = 7;
            $selecttable = mysqli_query($conn, "SELECT * FROM events WHERE clan_events = '$clan' ORDER BY `events_id` DESC ");
            $totalrow = mysqli_num_rows($selecttable);
            $totalpages = ceil($totalrow / $rowdataonpage);
            if (isset($_GET["page"])) {
                $activepage = $_GET["page"];
            } else {
                $activepage = 1;
            };
            $firstpage = ($rowdataonpage *  ($activepage)) - $rowdataonpage;
            
            $fconn = mysqli_query($conn, "SELECT * FROM events WHERE clan_events = '$clan' ORDER BY `events_id` DESC LIMIT $firstpage, $rowdataonpage");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $event_title = $rows['events_title'];
                $posted = $rows['posted_by'];
                $date = $rows['events_date'];
                $eid = $rows['events_id'];
                $section = $rows['section'];
                echo '<a href="topic.php?post=' . $eid . '&clan='.$clan.'&cat='.$section.'"> ' . $event_title . '</a>';
                

                echo '<p>By : ' . $posted . ', ' . $date . ' </p>';
            }
            ?>
        </div>
        <div class="num-page">
            <?php
            for ($i = 1; $i <= $totalpages; $i++) {
                echo '<a href="events.php?clan=' . $clan . '&page=' . $i . '">' . $i . '</a>';
                
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
                        <label for="guides-title">Events</label> 
                        <input type="text" name="event-title" id="guides-title" placeholder="enter title" maxlength="50" required>
                        <textarea name="event-content" id="post_desc" maxlength="6000" required></textarea>
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
<script src="post4.js"></script>
</body>

</html>