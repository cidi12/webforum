<?php 
require '../functions.php';
global $conn;
$count = mysqli_query($conn, "SELECT clan, section, reported_by,post_id, post_title, post_content, post_by, COUNT(*) as count FROM post_reported GROUP BY post_id ORDER BY `count` DESC;");

$dpost = $_POST["dpost"];
$dclan= $_POST["dclan"];
$dsec= $_POST["dsec"];
$drep= $_POST["drep"];
$dby= $_POST["dby"];
$dtitle= $_POST["dtitle"];
$dpcontent= $_POST["dpcontent"];

if (isset($_POST["admignore"])) {
    echo '<script>
    
        ' . mysqli_query($conn, "DELETE FROM post_reported WHERE post_id = $dpost AND clan = '$dclan'AND section = '$dsec'") . '
       window.location.replace("admindashboard.php")
        </script>';

}
?>