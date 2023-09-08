<?php
require '../htmlpurifier\library\HTMLPurifier.safe-includes.php';
require '../functions.php';
$config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.Definition.Impl', null);
        $config->set('HTML.AllowedElements', 'img, br');
        $config->set('HTML.AllowedAttribute', []);
        $purifier = new HTMLPurifier($config);


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
    <title>View Topic</title>
</head>

<?php
global $conn;
$clan = $_GET['clan'];
echo '<body class="topic-body" style="background-image: url(' . $clan . '.webp);">';
?>

<div class="topic-wrapper">
    <div class="topic-owner-post">
        <div class="topic-owner-container">
            <?php
            global $conn;
            $pconfirmation = "'Delete postingan ini?'";
            $cconfirmation = "'Delete komentar ini?'";
            $editcommconfirm = "'Edit komentar ini?'";
            $data = $_GET['post'];
            $section = $_POST["sid"];
            $kategori = $_GET["cat"];
            echo '<script>if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }</script>';


            // -----------------clan guides------------ //

            $fconn = mysqli_query($conn, "SELECT * FROM guides WHERE guides_id = $data AND guide_for = '$clan' AND section ='$section' ");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $title = $rows['guides_title'];
                $posted = $rows['guides_by'];
                $date = $rows['guides_date'];
                $des = $rows['guides_content'];
                $race = $rows['guide_for'];
                $pid = $rows['guides_id'];
                $gsection = $rows['section'];
                function editPost()
                {
                    if (isset($_POST["editPbtn"])) {
                        global $conn;
                        $data = $_GET["post"];
                        $clan = $_GET["clan"];
                        $pid = $_POST["pid"];
                        $editcontent = ($_POST["editpost"]);
                        $ownuser = $_SESSION["user_name"];

                        if (empty($editcontent)) {
                            echo "<script>
                                alert('Postingan tidak boleh kosong');
                                document.location.href = '';
                                </script>";
                        } else {
                            if (strlen($editcontent) > 2777) {
                                echo "<script>
                                    alert('Isiannya kebanyakan tuh');
                                    document.location.href = '';
                                    </script>";
                            } else {
                                echo '<script>
                                    ' . mysqli_query($conn, "UPDATE guides SET guides_content = '$editcontent' WHERE guides_by = '$ownuser' AND guides_id = $pid")
                                                        . ';
                                    window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '")
                                    alert("Postingan berhasil diedit")
                                    </script>';
                            }
                        }
                    }
                }
                function deleteGuidePost()
                {
                    if (isset($_POST["deletepostbtn"])) {
                        global $conn;
                        $data = $_GET["post"];
                        $clan = $_GET["clan"];
                        $pid = $_POST["pid"];

                        echo '<script>
                        ' . mysqli_query($conn, "DELETE FROM guides WHERE guides_id = $pid AND guide_for = '$clan'") . ';
                        ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pid AND comment_clan = '$clan'") . '
                        window.location.replace("guides.php?clan_guides=' . $clan . '")
                        </script>';
                    }
                }

                echo '<div class="owner-title">
                <p> ' . $title . ' </p>
                
                </div>';
                echo '<div class="owner-by">
                <p>By  ' . $posted . ' </p>
                </div>';
                echo '<div class="owner-date">
                <p> ' . $date . ' </p>
                </div>';
                echo '<div class="owner-content">
                <div class="owner-content-contained">
                            <p> ' . $purifier->purify($des) . '</p>
                             </div>
                </div>';
                echo '<div class="comment-btn">
                <a href="postcomment.php?topic=' . $data . '&clan=' . $race . '")"  >Comment</a>
               </div>';
                echo '
                <div class="post-btn-back">
                <a href="guides.php?clan_guides=' . $race . '">Back</a>
                </div>';

                if (($_SESSION["user_name"]) == $posted) {
                    
                    echo '<div class="editpostbtn">
                    <input type="button" value="Edit" id="editpostbtn">
                    </div>';
                    echo  '<div class="delete-btn-area">
                    <form action="' . deleteGuidePost() . '" method="POST">
                    <input type="hidden" name="pid" value="' . $data . '">
                    <button type="submit" name="deletepostbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                </form>

                
                 </div>
                 ';
                
                }
            }
            // -----------------------------//

            // ----------- post your stats-------------//

            $fconn = mysqli_query($conn, "SELECT * FROM showoff WHERE pys_id = $data AND clan = '$clan' AND section = '$section'");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $title2 = $rows['pys_title'];
                $posted2 = $rows['pys_by'];
                $date2 = $rows['pys_date'];
                $des2 = $rows['pys_desc'];
                $race2 = $rows['clan'];
                $pysid = $_POST['cid'];
                $psection = $_POST['sid'];

                function editPostYourStats()
                {
                    if (isset($_POST["editPybtn"])) {
                        global $conn;
                        $data2 = $_GET["post"];
                        $clan2 = $_GET["clan"];
                        $pysid = $_POST["pysid"];
                        $pyseditcontent = ($_POST["pyscontent"]);
                        $ownuser2 = $_SESSION["user_name"];
                        $psec = $_POST["pyssection"];
                        

                        if (empty($pyseditcontent)) {
                            echo "<script>
                                alert('Hayoo diotak-atik ya? komentar tidak boleh kosong');
                                document.location.href = '';
                                </script>";
                        } else {
                            if (strlen($pyseditcontent) > 2777) {
                                echo "<script>
                                    alert('Hayoo diotak-atik ya? komentarnya kebanyakan tuh');
                                    document.location.href = '';
                                    </script>";
                            } else {
                                echo '<script>
                                    ' . mysqli_query($conn, "UPDATE showoff SET pys_desc = '$pyseditcontent' WHERE pys_by = '$ownuser2' AND pys_id = $pysid")
                                                        . ';
                                    window.location.replace("topic.php?clan=' . $clan2 . '&cat=' . $psec . '")
                                    alert("Postingan berhasil diedit")
                                    </script>';
                            }
                        }
                    }
                }
              
                

                echo '<div class="owner-title">
                <p> ' . $title2 . ' </p>
                </div>';
                echo '<div class="owner-by">
                <p>By  ' . $posted2 . ' </p>
                </div>';
                echo '<div class="owner-date">
                <p> ' . $date2 . ' </p>
                </div>';
                echo '<div class="owner-content">
                           <div class="owner-content-contained">
                            <p> ' . $purifier->purify($des2) . '</p>
                             </div>
                     </div>';
                
                echo '<div class="comment-btn">
                <a href="postcomment.php?topic=' . $data . '&clan=' . $race2 . '")"  >Comment</a>
               </div>';
                echo '
                <div class="post-btn-back">
                <a href="post-your-stats.php?post-your-stats=' . $race2 . '">Back</a>
                </div>';

                if (($_SESSION["user_name"]) == $posted2) {
                    echo '<div class="editpostbtn">
                    <input type="button" value="Edit" id="editpostbtn">
                    </div>';
                    echo  '<div class="delete-btn-area">
                    <form action="delete.php?post='.$pysid.'&clan='.$clan.'&cat='.$psection.'" method="POST">
                    <input type="text" name="pysid" value="' . $pysid . '">
                    <input type="text" name="pyssection" value="' . $psection . '">
                    <button type="submit" name="deletepyspostbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                </form>
                 </div>';
                }
            }
            // ------------------------------------------//

           
            // --------- Events start------------------//

            $fconn = mysqli_query($conn, "SELECT * FROM events WHERE events_id = $data AND clan_events = '$clan' AND section = '$section'");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $etitle = $rows['events_title'];
                $eposted = $rows['events_by'];
                $edate = $rows['events_date'];
                $edes = $rows['events_content'];
                $erace = $rows['clan_events'];
                $epid = $rows['events_id'];
                $esection = $rows['section'];
                function deleteEventPost()
                {
                    if (isset($_POST["deleteeventbtn"])) {
                        global $conn;
                        $data = $_GET["post"];
                        $clan = $_GET["clan"];
                        $pidevents = $_POST["epid"];

                        echo '<script>
                        ' . mysqli_query($conn, "DELETE FROM news WHERE news_id = $pidevents AND news_for = '$clan'") . ';
                        ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pidevents AND comment_clan = '$clan'") . '
                        window.location.replace("events.php?clan_events=Elf=' . $clan . '")
                        </script>';
                    }
                }

                echo '<div class="owner-title">
                <p> ' . $etitle . ' </p>
                </div>';
                echo '<div class="owner-by">
                <p>By  ' . $eposted . ' </p>
                </div>';
                echo '<div class="owner-date">
                <p> ' . $edate . ' </p>
                </div>';
                echo '<div class="owner-content">
                <div class="owner-content-contained">
                <p> ' . $purifier->purify($edes) . '</p>
                 </div>
               
                </div>';
                echo '<div class="comment-btn">
                <a href="postcomment.php?topic=' . $data . '&clan=' . $erace . '")"  >Comment</a>
               </div>';
                echo '
                <div class="post-btn-back">
                <a href="events.php?clan_events=' . $erace . '">Back</a>
                </div>';

                if (($_SESSION["user_name"]) == $eposted) {
                    echo  '<div class="delete-btn-area">
                    <form action="' . deleteEventPost() . '" method="POST">
                    <input type="hidden" name="epid" value="' . $data . '">
                    <button type="submit" name="deleteeventbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                </form>
                 </div>';
                }
            }
            // ---------------------------------------------------//
            // ------------------ news start ----------------------//
            $fconn = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $data AND news_for = '$clan' AND section = '$section' ");
            while ($rows = mysqli_fetch_assoc($fconn)) {
                $ntitle = $rows['news_title'];
                $nposted = $rows['news_by'];
                $ndate = $rows['news_date'];
                $ndes = $rows['news_content'];
                $nrace = $rows['news_for'];
                $npid = $rows['news_id'];
                $nsection = $rows['section'];
                function deleteNewsPost()
                {
                    if (isset($_POST["deletenewsbtn"])) {
                        global $conn;
                        $data = $_GET["post"];
                        $clan = $_GET["clan"];
                        $pidnews = $_POST["pid"];

                        echo '<script>
                        ' . mysqli_query($conn, "DELETE FROM news WHERE news_id = $pidnews AND news_for = '$clan'") . ';
                        ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pidnews AND comment_clan = '$clan'") . '
                        window.location.replace("news.php?clan_news=' . $clan . '")
                        </script>';
                    }
                }

                echo '<div class="owner-title">
                <p> ' . $ntitle . ' </p>
                </div>';
                echo '<div class="owner-by">
                <p>By  ' . $nposted . ' </p>
                </div>';
                echo '<div class="owner-date">
                <p> ' . $ndate . ' </p>
                </div>';
                echo '<div class="owner-content">
                <div class="owner-content-contained">
                <p> ' . $purifier->purify($ndes) . '</p>
                 </div>
              
                </div>';
                echo '<div class="comment-btn">
                <a href="postcomment.php?topic=' . $data . '&clan=' . $nrace . '")"  >Comment</a>
               </div>';
                echo '
                <div class="post-btn-back">
                <a href="news.php?clan_news=' . $nrace . '">Back</a>
                </div>';

                if (($_SESSION["user_name"]) == $nposted) {
                    echo  '<div class="delete-btn-area">
                    <form action="' . deleteNewsPost() . '" method="POST">
                    <input type="hidden" name="pid" value="' . $data . '">
                    <button type="submit" name="deletenewsbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                </form>
                 </div>';
                }
            }

            ?>
        </div>

    </div>
    <!-- edit and delete komentar start here -->
    <div>
        <?php
        global $conn;
        $fconn2 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan'");

        function deleteComment()
        {
            if (isset($_POST["deletebtn"])) {
                global $conn;
                $data = $_GET["post"];
                $clan = $_GET["clan"];
                $cid = $_POST["cid"];

                echo '<script>
                ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_id = $cid") . ';
                window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '")
                </script>';
            }
        };
        while ($rows = mysqli_fetch_assoc($fconn2)) {
            $comment = $rows['comment_content'];
            $commenter = $rows['comment_by'];
            $commdate = $rows['comment_date'];
            $commentfor = $rows['comment_for'];
            $commentclan = $rows['comment_clan'];
            $commentid = $rows['comment_id'];
            echo '<div class="topic-member-reply">
                <div class="comment-from">
                     <p>By ' . $commenter . ' </p>
                </div>
                <div class="comment-date">
                     <p>on : ' . $commdate . ' </p>
                </div>
                <div class="comment-content">
                <div class="comment-content-contained">
                <p> ' . $purifier->purify($comment) . '</p>
                    
                 </div>
                
                    
                 </div>
            </div>';
            if (($_SESSION["user_name"]) == $commenter) {

                echo  '<div class="comment-btn-area">

                <form action="editcomment.php?post='.$data.'&clan='.$clan.'" method="POST">
                <input type="hidden" name="cid" value="' . $commentid . '">
                <textarea hidden name="txt">'.$comment.'</textarea>
                <button type="submit" name="deletebtn" onclick="return confirm(' . $editcommconfirm . ')">Edit</button>
            </form>

                <form action="' . deleteComment() . '" method="POST">
                <input type="hidden" name="cid" value="' . $commentid . '">
                <button type="submit" name="deletebtn" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
            </form>
                 </div>
                   ';
            }
        }
        ?>

    </div>
</div>
<div></div>
<?php 
global $conn;

// -----------------clan guides edit post------------ //

$fconn = mysqli_query($conn, "SELECT * FROM guides WHERE guides_id = $data AND guide_for = '$clan'");
while (mysqli_fetch_assoc($fconn)){
    echo '<div class="editpost">
    <form action="' . editPost() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="pid" value="' . $pid . '">
            <textarea name="editpost" id="edit_post_desc" maxlength="4000" required>'.$des.'</textarea>
            <button type="submit" name="editPbtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
}





// ------post your stats edit post---------//
$fconn = mysqli_query($conn, "SELECT * FROM showoff WHERE pys_id = $data AND clan = '$clan'");  
while (mysqli_fetch_assoc($fconn)){
    echo '<div class="editpost">
    <form action="' . editPostYourStats() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="pysid" value="' . $pysid . '">
            <textarea name="pyscontent" id="edit_post_desc" maxlength="4000" required>'.$des2.'</textarea>
            <button type="submit" name="editPybtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
}     
?>
</div>



</body>
<script src="topic.js"></script>
</html>