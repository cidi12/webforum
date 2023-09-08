<?php 
require '../functions.php';
global $conn;
$count = mysqli_query($conn, "SELECT clan, section, reported_by,post_id, post_title, post_content, post_by, COUNT(*) as count FROM post_reported GROUP BY post_id ORDER BY `count` DESC;");
while ($co = mysqli_fetch_assoc($count)){

$dpost = $_POST["dpost"];
$dclan= $_POST["dclan"];
$dsec= $_POST["dsec"];
$drep= $_POST["drep"];
$dby= $_POST["dby"];
$dtitle= $_POST["dtitle"];
$dpcontent= $_POST["dpcontent"];
if (isset($_POST["admdelpos"])) {
    echo '<script>
    ' . mysqli_query($conn, "DELETE FROM guides WHERE guides_id = $dpost AND guide_for = '$dclan'AND section = '$dsec'") . '
        ' . mysqli_query($conn, "DELETE FROM news WHERE news_id = $dpost AND news_for = '$dclan' AND section = '$dsec'") . ';
        ' . mysqli_query($conn, "DELETE FROM events WHERE events_id = $dpost AND clan_events = '$dclan'AND section = '$dsec'") . '
        ' . mysqli_query($conn, "DELETE FROM showoff WHERE pys_id = $dpost AND clan = '$dclan'AND section = '$dsec'") . '
       
        ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $dpost AND comment_clan = '$dclan' AND section = '$dsec'") . '
        
       window.location.replace("admindashboard.php")
        </script>';
}
}
if (isset($_POST["admdelpos"])) {
    echo '<script>
    
        ' . mysqli_query($conn, "DELETE FROM post_reported WHERE post_id = $dpost AND clan = '$dclan'AND section = '$dsec'") . '
       window.location.replace("admindashboard.php")
        </script>';

}
?>