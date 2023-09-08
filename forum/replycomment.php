<?php

require '../functions.php';

if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>
<?php
global $conn;


function replyComment()
{
    if (isset($_POST["replybtn"])) {
        global $conn;
        $data = $_GET["post"];
        $clan = $_GET["clan"];
        $ceid = $_POST["crid"];
        $reply = ($_POST["replycommentcontent"]);
        $ownuser = $_SESSION["user_name"];
        $edsec = $_POST["srid"];
        $oricomment = $_POST["oricommentcontent"];

        if (empty($reply)) {
            echo '<script>
            alert("Komentar tidak boleh kosong");
            window.location.replace("topic.php?post='.$data.'&clan='.$clan.'&cat='.$edsec.'")
            </script>';
        } else {
            if (strlen($ceid) > 2777) {
                echo "<script>
                alert('Komentarnya kebanyakan tuh');
                document.location.href = '';
                </script>";
            } else {
                echo '<script>
                ' . mysqli_query($conn, "INSERT INTO comments  VALUES ('','$ownuser','$clan','$reply' ,current_timestamp(),'$data','$edsec','$oricomment')")
                    . ';
                window.location.replace("topic.php?post='.$data.'&clan='.$clan.'&cat='.$edsec.'")
                alert("Comment added!")
                </script>';
            }
        }
      
        

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Reply comment</title>
</head>
<?php global $conn;
$id = $_POST["cid"];
$ccid = $_POST["ccid"];
$txt = $_POST["txt"];
$clan = $_GET['clan'];
$data = $_GET["post"];
$comsec = $_POST["sid"];


echo '<body class="clan-guides-body" style="background-image: url(' . $clan . '.webp);">';
?>
      <div class="reply-a-comment"><?php
            echo '
        <form action="' . replyComment() . '" method="POST">
        <div class="edit-comment-form">
        <label id="reply-label">Reply to</label>
            <input type="hidden" name="crid" value="' . $id . '">
            <input type="text" name="ccrid" value="'.$ccid.'" id="reply-to" readonly>
            <input type="hidden" name="srid" value="'.$comsec.'">
            <textarea name="oricommentcontent" id="ori_desc" maxlength="2777" readonly wrap=hard ">'.$ccid.' wrote :<br><br>'.$txt.'</textarea>
            
            <textarea name="replycommentcontent" id="reply_desc" maxlength="2777" required></textarea>
            <button type="submit" name="replybtn" >Reply</button>
            <input type="button" value="New Line" id="rcomment_nl">
            <input type="button" value="Insert Image" id="rcomment_insertimg">
            <a href="topic.php?post='.$data.'&clan='.$clan.'&cat='.$comsec.'">Back</a>
            
            
        </form>
        </div>';

            ?>
    </div>
    <script src="replycomment.js"></script>
</body>
</html>

  



</html>