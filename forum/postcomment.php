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
    <title>Your comment</title>
</head>
<?php
global $conn;
$clan = $_GET['clan'];
$data = $_POST["cid"];
$id = $_GET["post"];
$method = $_SERVER["REQUEST_METHOD"];
$cuser = $_SESSION["user_name"];
$sec = $_POST["sid"];
if ($method == 'POST' && isset($_POST["comment-post"])) {
    
    $cdesc = ($_POST["comment-desc"]);
    $cdata = $_POST["topic"];
    $csec = $_POST["section"];
    if (empty($cdesc)) {
        echo "<script>
        alert('Komentar tidak boleh kosong');
        document.location.href = '';
        </script>";
    } else {
        if (strlen($cdesc) > 2777) {
            echo "<script>
            alert('Komentarnya kebanyakan tuh');
            document.location.href = '';
            </script>";
        } else {
            mysqli_query($conn, "INSERT INTO comments VALUES('','$cuser','$clan','$cdesc' ,current_timestamp(),'$cdata','$csec','')");
            echo "<script>
             alert('Comment added!');
               </script>";
             echo '<script>window.location.replace("topic.php?post=' . $id . '&clan='.$clan.'&cat='.$csec.'")</script>' ;
             
        }
    }
}

?>
<?php
global $conn;

echo '<body class="topic-body" style="background-image: url(' . $clan . '.webp);">';
?>

<div class="edit-a-comment">
    <div>
        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
            <div class="comment-form">
                <label for="comment-desc">Write your comment</label>
                <textarea name="comment-desc" id="comment_desc" maxlength="2777" required ></textarea>
                <?php 
                echo '<input type="hidden" name="section" id="" value="'.$sec.'">';
               
                echo '<input type="hidden" name="topic" id="" value="'.$data.'">';
            
                ?>
                <button type="submit" name="comment-post">Post</button>
                <input type="button" value="New Line" id="comment_nl">
                <input type="button" value="Insert Image" id="comment_insertimg">
               
            </div>
        </form>
    </div>
    <div class="hard-btn-back">
        <?php
        global $conn;
        
        echo '<a href="topic.php?post=' . $id . '&clan='.$clan.'&cat='.$sec.'">Back</a>';
            
        
         ?>
    </div>
</div>
<script src="comment.js"></script>
</body>


</html>
