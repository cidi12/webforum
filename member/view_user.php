<?php
require '../htmlpurifier/library/HTMLPurifier.safe-includes.php';
require '../functions.php';
$config = HTMLPurifier_Config::createDefault();
$config->set('Cache.Definition.Impl', null);
$config->set('HTML.AllowedElements', 'img, br');
$config->set('HTML.AllowedAttribute', []);
$purifier = new HTMLPurifier($config);
$nowuser = $_SESSION["user_name"];

$sender = $_GET["usr"];
$query = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$sender'");
$res = mysqli_fetch_assoc($query);
$gmbr = $res['profile_pic'];
$bgcpic = $res['bgpic'];
if (!isset($_SESSION["login"])) {
    echo "<script>
        document.location.href = '../index.php';
        </script>";
}
if ($_GET["usr"] == $nowuser) {
    echo '<script>
    window.location.replace("member.php")</script>';
}
if ($_GET["usr"] === null) {
    echo '<script>
    window.location.replace("member.php")</script>';
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Member</title>
    <link rel="stylesheet" href="../style.css">
</head>

<?php
echo '<body class="topic-body" style="background-image: url(../profilepicture/'.$bgcpic.');">';
?>

<div class="viewmember-dashboard-container">
    <div class="viewmemberbody-bg">
        <div class="viewmember-container">
            <div class="viewmember-profile">
                <?php
                global $conn;
                $username = $_SESSION["user_name"];
                $query = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$sender'");
                $res = mysqli_fetch_assoc($query);
                $nickname = $res['user_name'];
                $gmbr = $res['profile_pic'];
                echo '<img src="../profilepicture/' . $gmbr . '" alt="">
                <p>' . $nickname . '</p>';
                if ($_SESSION["member"]){
                echo '<a href="member.php?usr='.$nickname.'">Send Message</a>';
                } else if ($_SESSION["gm"]){
                    echo '<a href="../admin/admindashboard.php?usr='.$nickname.'">Send Message</a>';
                }
               
                ?>

            </div>
            <div class="pp-bg">

            </div>
        </div>

    </div>

    <div class="viewmember-activity">
        <div class="viewmember-post">
            <?php
            global $conn;
            $query2 = mysqli_query($conn, "SELECT * FROM guides WHERE guides_by = '$sender' ORDER BY guides_id DESC");
            while ($col = mysqli_fetch_assoc($query2)) {
                $id = $col['guides_id'];
                $title = $col['guides_title'];
                $date = $col['guides_date'];
                $content = $col['guides_content'];
                $for = $col['guide_for'];
                $sec = $col['section'];
                echo '
                <div class="viewmemberpost-container">
               
                    <a href="../forum/topic.php?post=' . $id . '&clan=' . $for . '&cat=' . $sec . '">' . $purifier->purify($title) . '</a>
               
               
                    <p>' . $date . '</p>
               
               
                    <p>' . $purifier->purify($content) . '</p>
               
            </div>
            ';
            }
            ?>

        </div>
        <div class="viewmember-post2">
            <?php
            global $conn;
            $query3 = mysqli_query($conn, "SELECT * FROM showoff WHERE pys_by = '$sender' ORDER BY pys_id DESC");
            while ($col = mysqli_fetch_assoc($query3)) {
                $pid = $col['pys_id'];
                $ptitle = $col['pys_title'];
                $pdate = $col['pys_date'];
                $pcontent = $col['pys_desc'];
                $pfor = $col['clan'];
                $psec = $col['section'];
                echo '
                <div class="viewmemberpost-container">
                
                    <a href="../forum/topic.php?post=' . $pid . '&clan=' . $pfor . '&cat=' . $psec . '">' . $purifier->purify($ptitle) . '</a>
                    
                    
                    <p>' . $pdate . '</p>
                    
                    
                    <p> ' . $purifier->purify($pcontent) . '</p>
                    
                </div>
           ';
            }
            ?>
        </div>


    </div>
    <div class="view-title">
        <p>Forum's Posts</p>
    </div>
    </body>

</html>