<?php
require '../functions.php';
global $conn;

$count2 = mysqli_query($conn, "SELECT clan, reported_by, section, comment_id, comment_content, comment_by, COUNT(*) as count FROM comment_reported GROUP BY comment_id ORDER BY `count` DESC;");
while ($co = mysqli_fetch_assoc($count2)) {

    $dpost = $_POST["dpost"];
    $dclan = $_POST["dclan"];
    $dsec = $_POST["dsec"];
    $drep = $_POST["drep"];
    $dby = $_POST["dby"];
    $dpcontent = $_POST["dpcontent"];
    if (isset($_POST["admdelcom"])) {
        echo '<script>
        ' . mysqli_query($conn, "UPDATE comments SET reply_to = 'Message deleted!' WHERE reply_to = '$dby'+'wrote : <br><br>'+'$dpcontent' ") . '
                            ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_id = $dpost AND comment_clan = '$dclan' AND section = '$dsec'") . '
                            
                           window.location.replace("admindashboard.php")
                            </script>';
    }
}
if (isset($_POST["admdelcom"])) {
    echo '<script>
                        
                            ' . mysqli_query($conn, "DELETE FROM comment_reported WHERE comment_id = $dpost AND clan = '$dclan'AND section = '$dsec'") . '
                           window.location.replace("admindashboard.php")
                            </script>';
}
?>