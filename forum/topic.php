<?php
require '../htmlpurifier/library/HTMLPurifier.safe-includes.php';
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
            $reportpostconfirmation = "'Report this post?'";
            $ccreport = "'Report this comment?'";
            $pconfirmation = "'Delete this post?'";
            $cconfirmation = "'Delete this comment?'";
            $editcommconfirm = "'Edit comment?'";
            $data = $_GET['post'];
            $sec = $_GET["cat"];

            if ($_GET["cat"] == "character") {

                // ------post your stats---------//
                $fconn = mysqli_query($conn, "SELECT * FROM showoff WHERE pys_id = $data AND clan = '$clan' AND section= '$sec' ");

                while ($rows = mysqli_fetch_assoc($fconn)) {
                    $title2 = $rows['pys_title'];
                    $posted2 = $rows['pys_by'];
                    $date2 = $rows['pys_date'];
                    $des2 = $rows['pys_desc'];
                    $race2 = $rows['clan'];
                    $pysid = $rows['pys_id'];
                    $pyssection = $rows['section'];

                    function editPostYourStats()
                    {
                        if (isset($_POST["editPybtn"])) {
                            global $conn;
                            $data2 = $_GET["post"];
                            $clan2 = $_GET["clan"];
                            $pysid = $_POST["pysid"];
                            $pyseditcontent = ($_POST["pyscontent"]);
                            $ownuser2 = $_SESSION["user_name"];
                            $cat = $_GET["cat"];
                            if (empty($pyseditcontent)) {
                                echo "<script>
                     alert('oops some field is empty!');
                     document.location.href = '';
                     </script>";
                            } else {
                                if (strlen($pyseditcontent) > 2777) {
                                    echo "<script>
                         alert('Oops too many characters!');
                         document.location.href = '';
                         </script>";
                                } else {
                                    echo '<script>
                         ' . mysqli_query($conn, "UPDATE showoff SET pys_desc = '$pyseditcontent' WHERE pys_by = '$ownuser2' AND pys_id = $pysid")
                                        . ';
                         window.location.replace("topic.php?post=' . $data2 . '&clan=' . $clan2 . '&cat=' . $cat . '")
                         alert("Post edited")
                         </script>';
                                }
                            }
                        }
                    }
                    function deletePysPost()
                    {
                        if (isset($_POST["deletepyspostbtn"])) {
                            global $conn;
                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $pysid = $_POST["pysid"];
                            $delcat = $_GET["cat"];
                            echo '<script>
                            ' . mysqli_query($conn, "DELETE FROM showoff WHERE pys_id = $pysid AND clan = '$clan'") . ';
                            ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pysid AND comment_clan = '$clan'") . '
                            window.location.replace("post-your-stats.php?clan=' . $clan . '&cat=' . $delcat . '")
                            </script>';
                        }
                    }
                    function reportcharacterpost()
                    {
                        if (isset($_POST["reportpost"])) {
                            function reppost()
                            {
                                global $conn;
                                $data = $_GET["post"];
                                $clan = $_GET["clan"];
                                $user = $_POST["user"];
                                $delcat = $_GET["cat"];
                                $row = mysqli_query($conn, "SELECT * FROM `showoff` WHERE pys_id = $data");
                                $fetch = mysqli_fetch_assoc($row);

                                $title = $fetch['pys_title'];
                                $by = $fetch['pys_by'];
                                $desc = $fetch['pys_desc'];

                                $result = mysqli_query($conn, "SELECT * FROM post_reported WHERE post_id = $data AND post_by = '$by' AND post_title ='$title' AND reported_by = '$user' ");

                                if (mysqli_fetch_assoc($result)) {
                                    return false;
                                }
                                mysqli_query($conn, "INSERT INTO post_reported VALUES ('','$data','$title','$by' ,'$desc','$clan', '$user','$delcat')");
                                return mysqli_affected_rows($conn);
                            }

                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $user = $_POST["user"];
                            $delcat = $_GET["cat"];


                            if (reppost() > 0) {
                                echo '<script>
                              
                                window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $delcat . '")
                                            alert("Posts reported!")
                                            </script>';
                            } else {
                                echo '<script>
                                            alert("You have already report this post!");
                                           window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $delcat . '")
                                            </script>';
                            }
                        }
                    }


                    echo '<div class="owner-title">
                            <p> ' . $purifier->purify($title2) . ' </p>
                            </div>';
                    echo '<div class="owner-by">
                    <a target="_blank" href="../member/view_user.php?usr=' . $posted2 . '">By ' . $posted2 . '</a>
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
                            
                            <form action="postcomment.php?post=' . $data . '&clan=' . $race2 . '" method="POST">
                                <input type="hidden" name="cid" value="' . $data . '">
                                <input type="hidden" name="sid" value="' . $pyssection . '">
                                <button type="submit" name="guide">Coment</button>
                            </form>
                            </div>';
                    if ($_SESSION["user_name"] != $posted2 && $_SESSION["member"] == 1) {
                        echo '<div class="comment-btn">
                            
                    <form action="' . reportcharacterpost() . '" method="POST">
                    <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
                        <button type="submit" name="reportpost" onclick="return confirm(' . $reportpostconfirmation . ')">Report</button>
                    </form>
                    </div>';
                    }

                    echo '
                            <div class="post-btn-back">
                            <a href="post-your-stats.php?clan=' . $race2 . '&cat=character">Back</a>
                            </div>';

                    if (($_SESSION["user_name"]) == $posted2) {
                        echo '<div class="editpostbtn">
                                <input type="button" value="Edit" id="editpostbtn">
                                </div>';
                        echo  '<div class="delete-btn-area">
                                <form action="' . deletePysPost() . '" method="POST">
                                <input type="hidden" name="pysid" value="' . $data . '">
                                <button type="submit" name="deletepyspostbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                            </form>
                            </div>';
                    }
                }

                // -------------------------------------------------//
            } else if ($_GET["cat"] == "guides") {
                // -----------------clan guides------------ //

                $fconn = mysqli_query($conn, "SELECT * FROM guides WHERE guides_id = $data AND guide_for = '$clan' AND section= '$sec'");
                while ($rows = mysqli_fetch_assoc($fconn)) {
                    $title = $rows['guides_title'];
                    $posted = $rows['guides_by'];
                    $date = $rows['guides_date'];
                    $des = $rows['guides_content'];
                    $race = $rows['guide_for'];
                    $pid = $rows['guides_id'];
                    $csec = $rows['section'];
                    function editPost()
                    {
                        if (isset($_POST["editPbtn"])) {
                            global $conn;
                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $pid = $_POST["pid"];
                            $editcontent = ($_POST["editpost"]);
                            $ownuser = $_SESSION["user_name"];
                            $cat = $_GET["cat"];

                            if (empty($editcontent)) {
                                echo "<script>
                     alert('oops some field is empty!');
                     document.location.href = '';
                     </script>";
                            } else {
                                if (strlen($editcontent) > 2777) {
                                    echo "<script>
                         alert('Oops too many characters!');
                         document.location.href = '';
                         </script>";
                                } else {
                                    echo '<script>
                         ' . mysqli_query($conn, "UPDATE guides SET guides_content = '$editcontent' WHERE guides_by = '$ownuser' AND guides_id = $pid")
                                        . ';
                         window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $cat . '")
                         alert("Post edited")
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

                            $delcat = $_GET["cat"];

                            echo '<script>
                            ' . mysqli_query($conn, "DELETE FROM guides WHERE guides_id = $pid AND guide_for = '$clan'") . ';
                            ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pid AND comment_clan = '$clan'") . '
                            window.location.replace("guides.php?clan=' . $clan . '&cat=' . $delcat . '")
                            </script>';
                        }
                    }
                    function reportguidepost()
                    {
                        if (isset($_POST["reportguidepost"])) {
                            function reppostguide()
                            {
                                global $conn;
                                $data = $_GET["post"];
                                $clan = $_GET["clan"];
                                $user = $_POST["user"];
                                $delcat = $_GET["cat"];
                                $row = mysqli_query($conn, "SELECT * FROM `guides` WHERE guides_id = $data");
                                $fetch = mysqli_fetch_assoc($row);

                                $title = $fetch['guides_title'];
                                $by = $fetch['guides_by'];
                                $desc = $fetch['guides_content'];

                                $result = mysqli_query($conn, "SELECT * FROM post_reported WHERE post_id = $data AND post_by = '$by' AND post_title ='$title' AND reported_by = '$user' ");

                                if (mysqli_fetch_assoc($result)) {
                                    return false;
                                }
                                mysqli_query($conn, "INSERT INTO post_reported VALUES ('','$data','$title','$by' ,'$desc','$clan', '$user','$delcat')");
                                return mysqli_affected_rows($conn);
                            }

                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $user = $_POST["user"];
                            $delcat = $_GET["cat"];


                            if (reppostguide() > 0) {
                                echo '<script>
                          
                            window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $delcat . '")
                                        alert("Posts reported!")
                                        </script>';
                            } else {
                                echo '<script>
                                        alert("You already report this post!");
                                       window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $delcat . '")
                                        </script>';
                            }
                        }
                    }

                    echo '<div class="owner-title">
                        <p> ' . $purifier->purify($title) . ' </p>
                        </div>';
                    echo '<div class="owner-by">
                    <a target="_blank" href="../member/view_user.php?usr=' . $posted . '">By ' . $posted . '</a>
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
                
                        <form action="postcomment.php?post=' . $data . '&clan=' . $race . '" method="POST">
                        <input type="hidden" name="cid" value="' . $data . '">
                        <input type="hidden" name="sid" value="' . $csec . '">
                        <button type="submit" name="guide">Comment</button>
                    </form>


                        </div>';
                    if (($_SESSION["user_name"]) != $posted && $_SESSION["member"] == 1) {
                        echo '<div class="comment-btn">
                            
                        <form action="' . reportguidepost() . '" method="POST">
                        <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
                            <button type="submit" name="reportguidepost" onclick="return confirm(' . $reportpostconfirmation . ')">Report</button>
                        </form>
                        </div>';
                    }

                    echo '
                        <div class="post-btn-back">
                        <a href="guides.php?clan=' . $race . '&cat=guides">Back</a>
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
            } else if ($_GET["cat"] == "news") {
                // --------------------- news start ----------------------//
                $fconn = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $data AND news_for = '$clan' AND section= '$sec'");
                while ($rows = mysqli_fetch_assoc($fconn)) {
                    $ntitle = $rows['news_title'];
                    $nposted = $rows['news_by'];
                    $ndate = $rows['news_date'];
                    $ndes = $rows['news_content'];
                    $nrace = $rows['news_for'];
                    $npid = $rows['news_id'];
                    $nsec = $rows['section'];
                    function editPostNews()
                    {
                        if (isset($_POST["editNewsbtn"])) {
                            global $conn;
                            $data4 = $_GET["post"];
                            $clan4 = $_GET["clan"];
                            $npid = $_POST["npid"];
                            $newscontent = ($_POST["newscontent"]);
                            $ownuser2 = $_SESSION["user_name"];
                            $cat = $_GET["cat"];
                            if (empty($newscontent)) {
                                echo "<script>
                     alert('oops some field is empty!');
                     document.location.href = '';
                     </script>";
                            } else {
                                if (strlen($newscontent) > 2777) {
                                    echo "<script>
                         alert('Oops too many characters!');
                         document.location.href = '';
                         </script>";
                                } else {
                                    echo '<script>
                         ' . mysqli_query($conn, "UPDATE news SET news_content = '$newscontent' WHERE news_by = '$ownuser2' AND news_id = $npid")
                                        . ';
                         window.location.replace("topic.php?post=' . $data4 . '&clan=' . $clan4 . '&cat=' . $cat . '")
                         alert("Post edited")
                         </script>';
                                }
                            }
                        }
                    }
                    function deleteNewsPost()
                    {
                        if (isset($_POST["deletenewsbtn"])) {
                            global $conn;
                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $pidnews = $_POST["pid"];
                            $delcat = $_GET["cat"];

                            echo '<script>
                            ' . mysqli_query($conn, "DELETE FROM news WHERE news_id = $pidnews AND news_for = '$clan'") . ';
                            ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pidnews AND comment_clan = '$clan'") . '
                            window.location.replace("news.php?clan=' . $clan . '&cat=' . $delcat . '")
                            </script>';
                        }
                    }

                    echo '<div class="owner-title">
                        <p> ' . $purifier->purify($ntitle) . ' </p>
                        </div>';
                    echo '<div class="owner-by">
                    <a target="_blank" href="../member/view_user.php?usr=' . $nposted . '">By ' . $nposted . '</a>
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
                       
                        <form action="postcomment.php?post=' . $data . '&clan=' . $nrace . '" method="POST">
                        <input type="hidden" name="cid" value="' . $data . '">
                        <input type="hidden" name="sid" value="' . $nsec . '">
                        <button type="submit" name="guide">Comment</button>
                    </form>


                        </div>';
                    echo '
                        <div class="post-btn-back">
                        <a href="news.php?clan=' . $nrace . '&cat=news">Back</a>
                        </div>';

                    if (($_SESSION["user_name"]) == $nposted) {
                        echo ' <div class="editpostbtn">
                        <input type="button" value="Edit" id="editpostbtn">
                        </div>';
                        echo  '<div class="delete-btn-area">
                            <form action="' . deleteNewsPost() . '" method="POST">
                            <input type="hidden" name="pid" value="' . $data . '">
                            <button type="submit" name="deletenewsbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                        </form>
                        </div>';
                    }
                }

                // ---------------------------------------//
            } else if ($_GET["cat"] == "events") {
                // --------- Events start------------------//

                $fconn = mysqli_query($conn, "SELECT * FROM events WHERE events_id = $data AND clan_events = '$clan' AND section= '$sec'");
                while ($rows = mysqli_fetch_assoc($fconn)) {
                    $etitle = $rows['events_title'];
                    $eposted = $rows['posted_by'];
                    $edate = $rows['events_date'];
                    $edes = $rows['events_desc'];
                    $erace = $rows['clan_events'];
                    $epid = $rows['events_id'];
                    $esec = $rows['section'];
                    function editPostEvents()
                    {
                        if (isset($_POST["editEventbtn"])) {
                            global $conn;
                            $data3 = $_GET["post"];
                            $clan3 = $_GET["clan"];
                            $epid = $_POST["epid"];
                            $eventcontent = ($_POST["eventcontent"]);
                            $ownuser2 = $_SESSION["user_name"];
                            $cat = $_GET["cat"];
                            if (empty($eventcontent)) {
                                echo "<script>
                     alert('oops some field is empty!');
                     document.location.href = '';
                     </script>";
                            } else {
                                if (strlen($eventcontent) > 2777) {
                                    echo "<script>
                         alert('Oops too many characters!');
                         document.location.href = '';
                         </script>";
                                } else {
                                    echo '<script>
                         ' . mysqli_query($conn, "UPDATE events SET events_desc = '$eventcontent' WHERE posted_by = '$ownuser2' AND events_id = $epid")
                                        . ';
                         window.location.replace("topic.php?post=' . $data3 . '&clan=' . $clan3 . '&cat=' . $cat . '")
                         alert("Post edited")
                         </script>';
                                }
                            }
                        }
                    }


                    function deleteEventPost()
                    {
                        if (isset($_POST["deleteeventbtn"])) {
                            global $conn;
                            $data = $_GET["post"];
                            $clan = $_GET["clan"];
                            $pidevents = $_POST["epid"];
                            $delcat = $_GET["cat"];
                            echo '<script>
                            ' . mysqli_query($conn, "DELETE FROM news WHERE news_id = $pidevents AND news_for = '$clan'") . ';
                            ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_for = $pidevents AND comment_clan = '$clan'") . '
                            window.location.replace("events.php?clan=' . $clan . '&cat=' . $delcat . '")
                            </script>';
                        }
                    }

                    echo '<div class="owner-title">
                            <p> ' . $purifier->purify($etitle) . ' </p>
                            </div>';
                    echo '<div class="owner-by">
                    <a target="_blank" href="../member/view_user.php?usr=' . $eposted . '">By ' . $eposted . '</a>
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
                           
                            <form action="postcomment.php?post=' . $data . '&clan=' . $erace . '" method="POST">
                        <input type="hidden" name="cid" value="' . $data . '">
                        <input type="hidden" name="sid" value="' . $esec . '">
                        <button type="submit" name="guide">Comment</button>
                    </form>;


                            </div>';
                    echo '
                            <div class="post-btn-back">
                            <a href="events.php?clan=' . $erace . '&cat=events">Back</a>
                            </div>';

                    if (($_SESSION["user_name"]) == $eposted) {
                        echo ' <div class="editpostbtn">
                        <input type="button" value="Edit" id="editpostbtn">
                        </div>';
                        echo  '<div class="delete-btn-area">
                                <form action="' . deleteEventPost() . '" method="POST">
                                <input type="hidden" name="epid" value="' . $data . '">
                                <button type="submit" name="deleteeventbtn" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                            </form>
                            </div>';
                    }
                }
                // ---------------------------------------------------//
            }









            ?>
        </div>


    </div>
    <!-- edit and delete komentar start here -->
    <div>
        <?php
        global $conn;
        $globalcat = $_GET["cat"];

        function deleteComment()
        {
            if (isset($_POST["deletebtn"])) {

                global $conn;

                $data = $_GET["post"];
                $clan = $_GET["clan"];
                $cid = $_POST["cid"];
                $delsec = $_GET["cat"];
                $txt = $_POST['txt'];
                $ccid = $_POST["ccid"];

                echo '<script>
               
                
                ' . mysqli_query($conn, "UPDATE comments SET reply_to = 'Message deleted!' WHERE reply_to = '$ccid'+'wrote : <br><br>'+'$txt' ") . '
 ' . mysqli_query($conn, "DELETE FROM comments WHERE comment_id = $cid ") . ';
                window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $delsec . '")
                </script>';
            }
        };

        if ($_GET["cat"] == "character") {
            $rowdatapagepys = 30;
            $fconn22 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec'");
            $totrowpys = mysqli_num_rows($fconn22);
            $totpagepys = ceil($totrowpys / $rowdatapagepys);
            if (isset($_GET["page"])) {
                $activepagepys = $_GET["page"];
            } else {
                $activepagepys = 1;
            };
            $firstpys = ($rowdatapagepys *  ($activepagepys)) - $rowdatapagepys;
            $fconn2 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec' limit $firstpys, $rowdatapagepys ");
            while ($rows = mysqli_fetch_assoc($fconn2)) {
                $comment = $rows['comment_content'];
                $commenter = $rows['comment_by'];
                $commdate = $rows['comment_date'];
                $commentfor = $rows['comment_for'];
                $commentclan = $rows['comment_clan'];
                $commentid = $rows['comment_id'];
                $comsec = $rows['section'];
                $replyto = $rows['reply_to'];

                echo '  <div class="topic-member-reply">
                            <div class="comment-from">
                            <a target="_blank" href="../member/view_user.php?usr=' . $commenter . '">By ' . $commenter . '</a>

                            </div>
                            <div class="comment-date">
                                <p>on : ' . $commdate . ' </p>
                            </div>';


                if ($replyto == !null) {

                    echo ' 
                            <div class="comment-content2">
                                <div class="comment-content-contained2">';
                    echo '      
                                <p>' . $purifier->purify($replyto) . '</p>';
                    echo '</div>
                                </div>';
                }


                echo '<div class="comment-content">
                            <div class="comment-content-contained">
                            <p> ' . $purifier->purify($comment) . '</p>
                            </div>
                        </div>
                       
                      </div>';

                echo ' <div class="reply-button">
                <form action="replycomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <input type="hidden" name="ccid" value="' . $commenter . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="" >Reply</button>
                    </form>
            </div>';



                if (($_SESSION["user_name"]) != $commenter && $_SESSION["member"] == 1) {

                    echo ' <div class="reply-button">
                <form action="reportcomment.php" method="POST">
                        <input type="hidden" name="post" value="' . $data . '">
                        <input type="hidden" name="clan" value="' . $clan . '">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <input type="hidden" name="ccid" value="' . $commenter . '">
                        <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="reportcommentbtn" onclick="return confirm(' . $ccreport . ')" >Report</button>
                    </form>
            </div>';
                }
                if (($_SESSION["user_name"]) == $commenter) {

                    echo  '<div class="comment-btn-area">
        
                        <form action="editcomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $editcommconfirm . ')">Edit</button>
                    </form>
        
                        <form action="' . deleteComment() . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <input type="hidden" name="ccid" value="' . $commenter . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
                    </form>
                         </div>
                           ';
                }
            } ?>

            <div class="topic-page-number">
                <?php
                for ($py = 1; $py <= $totpagepys; $py++) {
                    echo '<a href="topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $globalcat . '&page=' . $py . '">' . $py . '</a>';
                }

                ?>
            </div>
        <?php
        } else if ($_GET["cat"] == "guides") {

            $rowdatapagepys = 30;
            $fconn22 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec'");
            $totrowpys = mysqli_num_rows($fconn22);
            $totpagepys = ceil($totrowpys / $rowdatapagepys);
            if (isset($_GET["page"])) {
                $activepagepys = $_GET["page"];
            } else {
                $activepagepys = 1;
            };
            $firstpys = ($rowdatapagepys *  ($activepagepys)) - $rowdatapagepys;
            $fconn2 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec' limit $firstpys, $rowdatapagepys ");
            while ($rows = mysqli_fetch_assoc($fconn2)) {
                $comment = $rows['comment_content'];
                $commenter = $rows['comment_by'];
                $commdate = $rows['comment_date'];
                $commentfor = $rows['comment_for'];
                $commentclan = $rows['comment_clan'];
                $commentid = $rows['comment_id'];
                $comsec = $rows['section'];
                $replyto = $rows['reply_to'];
                echo '  <div class="topic-member-reply">
                <div class="comment-from">
                <a target="_blank" href="../member/view_user.php?usr=' . $commenter . '">By ' . $commenter . '</a>
                </div>
                <div class="comment-date">
                    <p>on : ' . $commdate . ' </p>
                </div>';
                if ($replyto == !null) {
                    echo ' 
                <div class="comment-content2">
                    <div class="comment-content-contained2">
                    <p> ' . $purifier->purify($replyto) . '</p>
                </div>
            </div>';
                };
                echo '<div class="comment-content">
                <div class="comment-content-contained">
                <p> ' . $purifier->purify($comment) . '</p>
                </div>
            </div>
           
          </div>';
                echo ' <div class="reply-button">
    <form action="replycomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="" >Reply</button>
        </form>
</div>';
                if (($_SESSION["user_name"]) != $commenter && $_SESSION["member"] == 1) {

                    echo ' <div class="reply-button">
    <form action="reportcomment.php" method="POST">
            <input type="hidden" name="post" value="' . $data . '">
            <input type="hidden" name="clan" value="' . $clan . '">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="reportcommentbtn" onclick="return confirm(' . $ccreport . ')" >Report</button>
        </form>
</div>';
                }
                if (($_SESSION["user_name"]) == $commenter) {

                    echo  '<div class="comment-btn-area">
        
                        <form action="editcomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $editcommconfirm . ')">Edit</button>
                    </form>
        
                        <form action="' . deleteComment() . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <input type="hidden" name="ccid" value="' . $commenter . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
                    </form>
                         </div>
                           ';
                }
            }
        ?>

            <div class="topic-page-number">
                <?php
                for ($py = 1; $py <= $totpagepys; $py++) {
                    echo '<a href="topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $globalcat . '&page=' . $py . '">' . $py . '</a>';
                }

                ?>
            </div>
        <?php

        } else if ($_GET["cat"] == "events") {
            $rowdatapagepys = 30;
            $fconn22 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec'");
            $totrowpys = mysqli_num_rows($fconn22);
            $totpagepys = ceil($totrowpys / $rowdatapagepys);
            if (isset($_GET["page"])) {
                $activepagepys = $_GET["page"];
            } else {
                $activepagepys = 1;
            };
            $firstpys = ($rowdatapagepys *  ($activepagepys)) - $rowdatapagepys;
            $fconn2 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec' limit $firstpys, $rowdatapagepys ");
            while ($rows = mysqli_fetch_assoc($fconn2)) {
                $comment = $rows['comment_content'];
                $commenter = $rows['comment_by'];
                $commdate = $rows['comment_date'];
                $commentfor = $rows['comment_for'];
                $commentclan = $rows['comment_clan'];
                $commentid = $rows['comment_id'];
                $comsec = $rows['section'];
                $replyto = $rows['reply_to'];
                echo '  <div class="topic-member-reply">
                <div class="comment-from">
                <a target="_blank" href="../member/view_user.php?usr=' . $commenter . '">By ' . $commenter . '</a>
                </div>
                <div class="comment-date">
                    <p>on : ' . $commdate . ' </p>
                </div>';
                if ($replyto == !null) {
                    echo ' 
                <div class="comment-content2">
                    <div class="comment-content-contained2">
                    <p> ' . $purifier->purify($replyto) . '</p>
                </div>
            </div>';
                };
                echo '<div class="comment-content">
                <div class="comment-content-contained">
                <p> ' . $purifier->purify($comment) . '</p>
                </div>
            </div>
           
          </div>';
                echo ' <div class="reply-button">
    <form action="replycomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="" >Reply</button>
        </form>
</div>';
                if (($_SESSION["user_name"]) != $commenter && $_SESSION["member"] == 1) {

                    echo ' <div class="reply-button">
    <form action="reportcomment.php" method="POST">
            <input type="hidden" name="post" value="' . $data . '">
            <input type="hidden" name="clan" value="' . $clan . '">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="reportcommentbtn" onclick="return confirm(' . $ccreport . ')" >Report</button>
        </form>
</div>';
                }
                if (($_SESSION["user_name"]) == $commenter) {

                    echo  '<div class="comment-btn-area">
        
                        <form action="editcomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $editcommconfirm . ')">Edit</button>
                    </form>
        
                        <form action="' . deleteComment() . '" method="POST">
                        <input type="hidden" name="cid" value="' . $commentid . '">
                        <input type="hidden" name="sid" value="' . $comsec . '">
                        <input type="hidden" name="ccid" value="' . $commenter . '">
                        <textarea hidden name="txt">' . $comment . '</textarea>
                        <button type="submit" name="deletebtn" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
                    </form>
                         </div>
                           ';
                }
            }
        ?>

            <div class="topic-page-number">
                <?php
                for ($py = 1; $py <= $totpagepys; $py++) {
                    echo '<a href="topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $globalcat . '&page=' . $py . '">' . $py . '</a>';
                }

                ?>
            </div>
        <?php
        } else if ($_GET["cat"] == "news") {
            $rowdatapagepys = 30;
            $fconn22 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec'");
            $totrowpys = mysqli_num_rows($fconn22);
            $totpagepys = ceil($totrowpys / $rowdatapagepys);
            if (isset($_GET["page"])) {
                $activepagepys = $_GET["page"];
            } else {
                $activepagepys = 1;
            };
            $firstpys = ($rowdatapagepys *  ($activepagepys)) - $rowdatapagepys;
            $fconn2 = mysqli_query($conn, "SELECT * FROM comments WHERE comment_for = $data AND comment_clan = '$clan' AND section = '$sec' limit $firstpys, $rowdatapagepys ");
            while ($rows = mysqli_fetch_assoc($fconn2)) {
                $comment = $rows['comment_content'];
                $commenter = $rows['comment_by'];
                $commdate = $rows['comment_date'];
                $commentfor = $rows['comment_for'];
                $commentclan = $rows['comment_clan'];
                $commentid = $rows['comment_id'];
                $comsec = $rows['section'];
                $replyto = $rows['reply_to'];
                echo '  <div class="topic-member-reply">
                <div class="comment-from">
                <a target="_blank" href="../member/view_user.php?usr=' . $commenter . '">By ' . $commenter . '</a>
                </div>
                <div class="comment-date">
                    <p>on : ' . $commdate . ' </p>
                </div>';
                if ($replyto == !null) {
                    echo ' 
                <div class="comment-content2">
                    <div class="comment-content-contained2">
                    <p> ' . $purifier->purify($replyto) . '</p>
                </div>
            </div>';
                };
                echo '<div class="comment-content">
                <div class="comment-content-contained">
                <p> ' . $purifier->purify($comment) . '</p>
                </div>
            </div>
           
          </div>';
                echo ' <div class="reply-button">
    <form action="replycomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="" >Reply</button>
        </form>
</div>';
                if (($_SESSION["user_name"]) != $commenter && $_SESSION["member"] == 1) {

                    echo ' <div class="reply-button">
    <form action="reportcomment.php" method="POST">
            <input type="hidden" name="post" value="' . $data . '">
            <input type="hidden" name="clan" value="' . $clan . '">
            <input type="hidden" name="cid" value="' . $commentid . '">
            <input type="hidden" name="sid" value="' . $comsec . '">
            <input type="hidden" name="ccid" value="' . $commenter . '">
            <input type="hidden" name="user" value="' . $_SESSION["user_name"] . '">
            <textarea hidden name="txt">' . $comment . '</textarea>
            <button type="submit" name="reportcommentbtn" onclick="return confirm(' . $ccreport . ')" >Report</button>
        </form>
</div>';
                }
                if (($_SESSION["user_name"]) == $commenter) {

                    echo  '<div class="comment-btn-area">
            
                            <form action="editcomment.php?post=' . $data . '&clan=' . $clan . '" method="POST">
                            <input type="hidden" name="cid" value="' . $commentid . '">
                            <input type="hidden" name="sid" value="' . $comsec . '">
                            <textarea hidden name="txt">' . $comment . '</textarea>
                            <button type="submit" name="deletebtn" onclick="return confirm(' . $editcommconfirm . ')">Edit</button>
                        </form>
            
                            <form action="' . deleteComment() . '" method="POST">
                            <input type="hidden" name="cid" value="' . $commentid . '">
                            <input type="hidden" name="sid" value="' . $comsec . '">
                            <input type="hidden" name="ccid" value="' . $commenter . '">
                            <textarea hidden name="txt">' . $comment . '</textarea>
                            <button type="submit" name="deletebtn" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
                        </form>
                             </div>
                               ';
                }
            }   ?>

            <div class="topic-page-number">
                <?php
                for ($py = 1; $py <= $totpagepys; $py++) {
                    echo '<a href="topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $globalcat . '&page=' . $py . '">' . $py . '</a>';
                }

                ?>
            </div>
        <?php
        }






        ?>

    </div>

</div>
<div>

</div>
<?php
global $conn;
// ----------------- Events edit post-------------------//

// -----------------clan guides edit post------------ //
if ($_GET["cat"] == 'guides') {


    $fconn = mysqli_query($conn, "SELECT * FROM guides WHERE guides_id = $data AND guide_for = '$clan'");
    while (mysqli_fetch_assoc($fconn)) {
        echo '<div class="editpost">
    <form action="' . editPost() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="pid" value="' . $pid . '">
            <textarea name="editpost" id="edit_post_desc" maxlength="4000" required>' . $des . '</textarea>
            <button type="submit" name="editPbtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
    }
} else if ($_GET["cat"] == 'character') {

    // ------post your stats edit post---------//
    $fconn = mysqli_query($conn, "SELECT * FROM showoff WHERE pys_id = $data AND clan = '$clan'");
    while (mysqli_fetch_assoc($fconn)) {
        echo '<div class="editpost">
    <form action="' . editPostYourStats() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="pysid" value="' . $pysid . '">
            <textarea name="pyscontent" id="edit_post_desc" maxlength="4000" required>' . $des2 . '</textarea>
            <button type="submit" name="editPybtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
    }
} else if ($_GET["cat"] == 'events') {
    $fconn = mysqli_query($conn, "SELECT * FROM events WHERE events_id = $data AND clan_events = '$clan'");
    while (mysqli_fetch_assoc($fconn)) {
        echo '<div class="editpost">
    <form action="' . editPostEvents() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="epid" value="' . $epid . '">
            <textarea name="eventcontent" id="edit_post_desc" maxlength="4000" required>' . $edes . '</textarea>
            <button type="submit" name="editEventbtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
    }
} else if ($_GET["cat"] == 'news') {
    $fconn = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $data AND news_for = '$clan'");
    while (mysqli_fetch_assoc($fconn)) {
        echo '<div class="editpost">
    <form action="' . editPostNews() . '" method="POST">
        <div class="edit-post-form">
            <label>Edit your post</label>
            <input type="hidden" name="npid" value="' . $npid . '">
            <textarea name="newscontent" id="edit_post_desc" maxlength="4000" required>' . $ndes . '</textarea>
            <button type="submit" name="editNewsbtn">Edit</button>
            <input type="button" value="New Line" id="tpcomment_nl">
            <input type="button" value="Insert Image" id="tpcomment_insertimg">
            <input type="button" value="Back" id="editpostback">
    
        </div>
    </form>
    </div>';
    }
}
?>
</div>

<div class="home-btn-all">
    <a href="../index.php">Home</a>
</div>
<div class="dashboard-btn-all">
    <?php
    if ($_SESSION["member"]) {
        echo '<a href="../member/member.php">Dashboard</a>';
    } else {
        echo '<a href="../admin/admindashboard.php">Dashboard</a>';
    }
    ?>

</div>

</body>
<script src="topic.js"></script>

</html>