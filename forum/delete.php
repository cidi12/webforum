<?php
require '../functions.php';
if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>
<?php
global $conn;
$data = $_GET["post"];
$clan = $_GET["clan"];
$pysid = $_POST["pysid"];
$psec = $_POST["pyssection"];
echo '<script>
' . mysqli_query($conn, "DELETE FROM showoff WHERE pys_id = $pysid AND clan = '$clan' AND section = '$psec'") . ';
' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pysid AND comment_clan = '$clan'") . '
window.location.replace("post-your-stats.php?clan=' . $clan . '&cat='.$psec.'")
</script>';
?>


