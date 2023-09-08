<?php
require '../functions.php';
if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>
<?php
global $conn;


function EditComment()
{
    if (isset($_POST["editbtn"])) {
        global $conn;
        $data = $_GET["post"];
        $clan = $_GET["clan"];
        $ceid = $_POST["ceid"];
        $editcontent = ($_POST["editcommentcontent"]);
        $ownuser = $_SESSION["user_name"];
        $edsec = $_POST["seid"];

        if (empty($editcontent)) {
            echo '<script>
            alert("Komentar tidak boleh kosong");
            window.location.replace("topic.php?post='.$data.'&clan='.$clan.'&cat='.$edsec.'")
            </script>';
        } else {
            if (strlen($ceid) > 2777) {
                echo '<script>
                alert("Komentarnya kebanyakan tuh");
                window.location.replace("topic.php?post='.$data.'&clan='.$clan.'&cat='.$edsec.'")
                </script>';
            } else {
                echo '<script>
                ' . mysqli_query($conn, "UPDATE comments SET comment_content = '$editcontent' WHERE comment_by = '$ownuser' AND comment_id = $ceid")
                    . ';
                window.location.replace("topic.php?post='.$data.'&clan='.$clan.'&cat='.$edsec.'")
                alert("Comment editted!")
                </script>';
            }
        }


        echo '<script>
        ' . mysqli_query($conn, "UPDATE comments SET comment_content = '$editcontent' WHERE comment_by = '$ownuser' AND comment_id = $ceid")
            . ';
        window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '")
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Edit comment</title>
</head>
<?php global $conn;
$id = $_POST["cid"];
$txt = $_POST["txt"];
$clan = $_GET['clan'];
$data = $_GET["post"];
$comsec = $_POST["sid"];

echo '<body class="clan-guides-body" style="background-image: url(' . $clan . '.webp);">';
?>
      <div class="edit-a-comment"><?php
            echo '
        <form action="' . editComment() . '" method="POST">
        <div class="edit-comment-form">
        <label>Edit your comment</label>
            <input type="hidden" name="ceid" value="' . $id . '">
            <input type="hidden" name="seid" value="'.$comsec.'">
            <textarea name="editcommentcontent" id="edit_desc" maxlength="2777" required>'.$txt.'</textarea>
            <button type="submit" name="editbtn" >Edit</button>
            <input type="button" value="New Line" id="ecomment_nl">
            <input type="button" value="Insert Image" id="ecomment_insertimg">
            <a href="topic.php?post='.$data.'&clan='.$clan.'&cat='.$comsec.'">Back</a>
            
            
        </form>
        </div>';

            ?>
    </div>
    <script src="editcomment.js"></script>
</body>
</html>

  



</html>