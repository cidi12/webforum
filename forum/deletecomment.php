<?php
require '../functions.php';
if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>

<?php
global $conn;
$cuserdel = $_GET["nametopic"];
$cusercomm = $_GET["comment"];
$cclan = $_GET["user"];
$race = $_GET["clan"];

$nfetch = mysqli_query($conn, "SELECT * FROM comments WHERE comment_by = '$cclan'");


if (isset($_GET["post-your-stats"])) {

    $delpys =  mysqli_query($conn, "DELETE FROM comments WHERE comment_by = '$cclan' AND comment_content = '$cusercomm'");
    header('Location: post-your-stats.php?post-your-stats=' . $race . '');
    exit();
}
 else if (isset($_GET["clan_guides_detail"])) {
    $delguides = mysqli_query($conn, "DELETE FROM comments WHERE comment_by = '$cclan' AND comment_content = '$cusercomm';");
    header('Location: guides.php?clan_guides=' . $race . '');
}
else if (isset($_GET["clan_events_detail"])) {
    $delguides = mysqli_query($conn, "DELETE FROM comments WHERE comment_by = '$cclan' AND comment_content = '$cusercomm';");
    header('Location: events.php?clan_events=' . $race . '');
}
else if (isset($_GET["news_detail"])) {
    $delguides = mysqli_query($conn, "DELETE FROM comments WHERE comment_by = '$cclan' AND comment_content = '$cusercomm';");
    header('Location: news.php?clan_news=' . $race . '');
}

?>