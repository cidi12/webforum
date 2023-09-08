<?php
require '../htmlpurifier/library/HTMLPurifier.safe-includes.php';
require '../functions.php';
$config = HTMLPurifier_Config::createDefault();
$config->set('Cache.Definition.Impl', null);
$config->set('HTML.AllowedElements', 'img, br');
$config->set('HTML.AllowedAttribute', []);
$purifier = new HTMLPurifier($config);
if ((($_SESSION["member"] == 1)) || (!isset($_SESSION["login"])))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<?php
$username = $_SESSION["user_name"];
$sender = $_GET["usr"];
$query = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
$res = mysqli_fetch_assoc($query);
$gmbr = $res['profile_pic'];
$bgcpic = $res['bgpic'];
?>
<?php echo '<body class="topic-body" style="background-image: url(../profilepicture/' . $bgcpic . ');">'; ?>

<div class="admbody-bg">
    <div class="member-dashboard-container">
        <div class="memberbody-bg">
            <div class="member-container">
                <div class="member-profile">
                    <?php
                    global $conn;
                    $username = $_SESSION["user_name"];
                    $sender = $_GET["usr"];
                    $query = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$username'");
                    $res = mysqli_fetch_assoc($query);
                    $gmbr = $res['profile_pic'];
                    echo '<img src="../profilepicture/' . $gmbr . '" alt="">
                <p>' . $username . '</p>';
                    ?>


                </div>
                <div class="member-nav">
                    <a href="../home.php">Home</a>
                    <a href="../forum/longue.php">Forum</a>
                    <input type="button" value="Message" id="send-message">

                </div>
                <div class="member-message">
                    <a href="../logout.php" type="button"><img src="../logout.png" alt=""></a>

                </div>
            </div>

            <div class="msg-board">
                <div class="mem-activity">
                    <a href="#dashboard-view-title">Activity</a>
                    <a id="btn-change-profile">Change profile</a>
                </div>
                <img src="../bg-featured2.png" alt="">

                <?php

                global $conn;
                $rowdatapage = 5;
                $seltable = mysqli_query($conn, "SELECT * FROM chatting WHERE msg_from ='$username' GROUP BY msg_to ORDER BY MAX(date) DESC");
                $totrow = mysqli_num_rows($seltable);
                $totpages = ceil($totrow / $rowdatapage);
                if (isset($_GET["page"])) {
                    $activepage = $_GET["page"];
                } else {
                    $activepage = 1;
                };
                $first = ($rowdatapage *  ($activepage)) - $rowdatapage;

                $chats = mysqli_query($conn, "SELECT * FROM chatting WHERE msg_from ='$username' GROUP BY msg_to ORDER BY MAX(date) DESC LIMIT $first, $rowdatapage");

                while ($crows = mysqli_fetch_assoc($chats)) {
                    $chatme = $crows['msg_to'];
                    $chatfrom = $crows['msg_from'];
                    $profpic = $crows['profile_pic'];


                    echo '  <div class="sender-pp">
            <a href="admindashboard.php?usr=' . $chatme . '&page=' . $activepage . '">' . $chatme . '</a>
           
            <img src="../profilepicture/' . $profpic . '" alt="">
        </div>';
                }
                ?>

            </div>
            <div class="inbox-title">
                <p>Inbox </p>
            </div>
            <div class="inbox-list">

                <?php
                global $conn;
                $recquerry = mysqli_query($conn, "SELECT * FROM `chatting` WHERE msg_to = '$username' GROUP BY msg_from ORDER by MAX(date) DESC");
                while ($recfetch = mysqli_fetch_assoc($recquerry)) {
                    $recfrom = $recfetch['msg_from'];
                    $msto = $recfetch['msg_to'];
                    $ref = $recfetch['ref'];
                    if ($ref == 'sent') {
                        echo '<a href="admindashboard.php?usr=' . $recfrom . '&page=' . $activepage . '">' . $recfrom . '</a>';
                    }
                }
                ?>
            </div>


            <?php
            global $conn;
            $nameqr = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$sender'");
            $nameqfetch = mysqli_fetch_assoc($nameqr);
            $nameto2 = $nameqfetch['user_name'];

            echo ' <div class="sender-name">
            <p>' . $nameto2 . '</p>
            </div>';

            ?>

            <div class="chat-area">
                <?php


                $chatquery = mysqli_query($conn, "SELECT * FROM chatting WHERE msg_from = '$sender' AND msg_to = '$username' OR  msg_from ='$username' AND msg_to = '$sender' order by id desc LIMIT 0,50  ;");
                while ($rows = mysqli_fetch_assoc($chatquery)) {

                    $msg = $rows['mssg'];
                    $msg2 = $rows['mssg2'];
                    $msgto = $rows['msg_to'];
                    $msgfrom = $rows['msg_from'];
                    if ($msgto == !null) {
                        if ($msgfrom == $username) {
                            echo ' <div class="chat-area-receiver">
                         <p>' . $purifier->purify($msg) . '</p>
                        </div>
                       ';
                        } else {
                            echo ' <div class="chat-area-sender">
                         <p>' . $purifier->purify($msg) . '</p>
                        </div>
                       ';
                        }
                    }
                }

                ?>


            </div>

            <div class="send-msg">
                <form action="" method="post">

                    <textarea type="text" maxlength="200" minlength="1" name="msg-text" id="chat-text" required></textarea>
                    <?php echo '<input type="hidden" value="' . $sender . '" name="linksu">'; ?>
                    <button type="submit" name="send-msg">Send</button>
                </form>


            </div>

            <?php
            global $conn;
            $linkname2 = $_POST["linksu"];
            $msgvalue = $_POST["msg-text"];
            $query2 = mysqli_query($conn, "SELECT * FROM user WHERE user_name = '$sender'");
            $res2 = mysqli_fetch_assoc($query2);
            $oriname = $res2['user_name'];
            $profilepicture = $res2['profile_pic'];
            $nameq = mysqli_query($conn, "SELECT * FROM chatting WHERE msg_to = '$linkname2'");
            $namefetch = mysqli_fetch_assoc($nameq);
            $nameto = $namefetch['msg_to'];
            $reff = $namefetch['ref'];
            if (isset($_POST["send-msg"])) {
                if (empty($msgvalue)) {
                    echo "<script>
            alert('Message is empty!')</script>";
                    echo   '<script>window.location.replace("admindashboard.php")</script>';
                } else {
                    if (strlen($msgvalue) > 200) {
                        echo "<script>
                alert('Too much message!');
                </scrip>";
                        echo   '<script>window.location.replace("admindashboard.php")';
                    } else {
                        if (empty($linkname2) || $linkname2 == $_SESSION["user_name"]) {
                            echo "<script>
                        alert('No receiver');
                        </script>";
                            echo   '<script>window.location.replace("admindashboard.php")</script>';
                        } else {
                            if ($oriname == null) {
                                echo "<script>
                            alert('User Not found!');
                            </script>";
                                echo   '<script>window.location.replace("admindashboard.php")</script>';
                            } else {

                                mysqli_query($conn, "INSERT INTO chatting VALUES('','$msgvalue','sent','$linkname2','$username' ,current_timestamp(),'$profilepicture')");
                                mysqli_query($conn, "UPDATE chatting SET ref = '' WHERE msg_from = '$sender' AND msg_to = '$username'");
                                echo   '<script>window.location.replace("admindashboard.php?usr=' . $linkname2 . '&page=' . $activepage . '")</script>';
                            }
                        }
                    }
                }
            }




            ?>
            <div class="chat-bg">

            </div>
            <div class="page-numbers">
                <?php
                for ($j = 1; $j <= $totpages; $j++) {
                    echo '<a href="admindashboard.php?page=' . $j . '">' . $j . '</a>';
                }
                ?>

            </div>
        </div>
        <div class="pp-chat-bg">

        </div>
    </div>

    <div class="adm-container" id="dashboard-view-title">


        <div class="adm-body">
            <div class="labelreport">

                <p>Reported posts</p>


                <p>Reported comments</p>

            </div>
            <div class="reported-body">
                <div class="report-post">

                    <?php
                    global $conn;
                    $pconfirmation = "'Delete post?'";
                    $cconfirmation = "'Delete comment?'";
                    $count = mysqli_query($conn, "SELECT clan, section, reported_by,post_id, post_title, post_content, post_by, COUNT(*) as count FROM post_reported GROUP BY post_id, section  ORDER BY `count` DESC;");
                    while ($co = mysqli_fetch_assoc($count)) {
                        $id = $rows['id'];
                        $post_id = $co['post_id'];
                        $title = $co['post_title'];
                        $by = $co['post_by'];
                        $content = $co['post_content'];
                        $tot = $co['count'];
                        $clan = $co['clan'];
                        $sec = $co['section'];
                        $repby = $co['reported_by'];
                        echo ' 
                        
                        <div class="rep-body">
                                <p>
                                    Report count : ' . $tot . '
                                </p>
                                
                                <p>
                                    Post title : 
                                </p>
                                    
                                <a target="_blank" href="../forum/topic.php?post=' . $post_id . '&clan=' . $clan . '&cat=' . $sec . '">' . $purifier->purify($title) . '</a>
                               
                                <p>
                                    Category : ' . $clan . ' ' . $sec . '
                                </p>
                                <p>Post by : ' . $by . '
                                </p>
                                <div class="content_post">
                                    <p>Post content : </p> 
                                    <p>' . $purifier->purify($content) . '</p>
                                </div>
                                    <div>
                                        <form action="admdelpos.php" method="POST">
                                        <input type="hidden" name = "dpost" value=' . $post_id . '>
                                        <input type="hidden" name = "dclan" value=' . $clan . '>
                                        <input type="hidden" name = "dsec" value=' . $sec . '>
                                        <input type="hidden" name = "drep" value=' . $repby . '>
                                        <input type="hidden" name = "dby" value=' . $by . '>
                                        <input type="hidden" name = "dtitle" value=' . $title . '>
                                        <textarea hidden type="hidden" name="dpcontent" id="post_desc" maxlength="6000">' . $content . '</textarea>
                                        
                                        <button type="submit" name="admdelpos" onclick="return confirm(' . $pconfirmation . ')">Delete</button>
                                        </form>
                                    </div>
                                    <div>
                                        <form action="admignorepos.php" method="POST">
                                        <input type="hidden" name = "dpost" value=' . $post_id . '>
                                        <input type="hidden" name = "dclan" value=' . $clan . '>
                                        <input type="hidden" name = "dsec" value=' . $sec . '>
                                        <input type="hidden" name = "drep" value=' . $repby . '>
                                        <input type="hidden" name = "dby" value=' . $by . '>
                                        <input type="hidden" name = "dtitle" value=' . $title . '>
                                        
                                        <textarea hidden type="hidden" name="dpcontent" id="post_desc" maxlength="6000">' . $content . '</textarea>
                                        <button type="submit" name="admignore">Ignore</button>
                                        </form>
                                    </div>
                        </div>';
                    } ?>
                </div>



                <div class="report-comment">
                    <?php
                    global $conn;

                    $count2 = mysqli_query($conn, "SELECT clan, reported_by, section, comment_id, comment_content, comment_by, COUNT(*) as count FROM comment_reported GROUP BY comment_id ORDER BY `count` DESC;");
                    while ($co = mysqli_fetch_assoc($count2)) {
                        $post_id = $co['comment_id'];
                        $clan = $co['clan'];
                        $comby = $co['comment_by'];
                        $content = $co['comment_content'];
                        $repby = $co['reported_by'];
                        $csec = $co['section'];
                        $tot = $co['count'];

                        echo '
                <div class="rep-body">
                            <p>
                            Report count : ' . $tot . '
                            </p>
                            <p>
                            Category : ' . $clan . ' ' . $csec . '
                            </p>
                
                            <p>Comment by : ' . $comby . '
                            </p>
                            <div class="content_post">
                                <p>comment : </p> 
                                <p>' . $purifier->purify($content) . '</p>
                            </div>
                    <div>
                        <form action="admindelcom.php" method="POST">
                        <input type="hidden" name = "dpost" value=' . $post_id . '>
                        <input type="hidden" name = "dclan" value=' . $clan . '>
                        <input type="hidden" name = "dsec" value=' . $csec . '>
                        <input type="hidden" name = "drep" value=' . $repby . '>
                        <input type="hidden" name = "dby" value=' . $comby . '>
                       
                        <textarea hidden type="hidden" name="dpcontent" id="post_desc" maxlength="6000">' . $content . '</textarea>
                        <button type="submit" name="admdelcom" onclick="return confirm(' . $cconfirmation . ')">Delete</button>
                        </form>
                    </div>
                    <div>
                        <form action="admignorecom.php" method="POST">
                        <input type="hidden" name = "dpost" value=' . $post_id . '>
                        <input type="hidden" name = "dclan" value=' . $clan . '>
                        <input type="hidden" name = "dsec" value=' . $csec . '>
                        <input type="hidden" name = "drep" value=' . $repby . '>
                        <input type="hidden" name = "dby" value=' . $comby . '>
                        
                        <textarea hidden type="hidden" name="dpcontent" id="post_desc" maxlength="6000">' . $content . '</textarea>
                        <button type="submit" name="admignorecom">Ignore</button>
                        </form>
                    </div>
            
            </div>';
                    } ?>
                </div>
            </div>


        </div>
    </div>

    <div class="change-profile-container">
        <?php echo '<form action="' . uploadimage() . '" method="post" enctype="multipart/form-data">'; ?>
        <div class="updatepp-header-bar">
            <img src="../forum-nav.png" alt="">
        </div>
        <?php
        echo '
        <div class="profile-input">
            <p>Update image</p>
            <label for="pics">Select your picture</label>

            <input type="file" name="pics" value="' . $gmbr . '">
            <input type="hidden" name="oldpics" value="' . $gmbr . '">

            <label for="background">Select your background image</label>
            <input type="hidden" name="oldbg" value="' . $bgcpic . '">
            <input type="file" name="bground" value="' . $bgcpic . '">
           
            <button type="submit" name="submit-picture">Submit</button>
            <input id="update-cancel" type="button" value="Cancel">
        </div>';
        ?>


        </form>
    </div>
    <?php

    function uploadimage()
    {
        $directory = '../profilepicture/';
        function upload($file, $directory)
        {
            $directory = '../profilepicture/';



            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $uniqueFilename = uniqid() . '.' . $fileExtension;
                $filePath = $directory . $uniqueFilename;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    return $filePath;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        if (isset($_POST["submit-picture"])) {
            $uploadedFile1 = $_FILES['pics'];
            $uploadedFile2 = $_FILES['bground'];
            $oldpic = $_POST["oldpics"];
            $oldbg = $_POST["oldbg"];


            global $conn;

            $username = $_SESSION["user_name"];
            if (($uploadedFile1['error'] === 4)) {
                $uploadedFilePath2 = upload($uploadedFile2, $directory);
                mysqli_query($conn, "UPDATE user SET profile_pic = '$oldpic', bgpic = '$uploadedFilePath2' WHERE user_name = '$username'");
            }
            if (($uploadedFile2['error'] == 4)) {
                $uploadedFilePath1 = upload($uploadedFile1, $directory);
                mysqli_query($conn, "UPDATE user SET profile_pic = '$uploadedFilePath1', bgpic = '$oldbg' WHERE user_name = '$username'");
                mysqli_query($conn, "UPDATE chatting SET profile_pic = '$uploadedFilePath1' WHERE msg_to = '$username'");
            }
            if (($uploadedFile1['error'] == 4) && ($uploadedFile2['error'] == 4)) {
                mysqli_query($conn, "UPDATE user SET profile_pic = '$oldpic', bgpic = '$oldbg' WHERE user_name = '$username'");
                mysqli_query($conn, "UPDATE chatting SET profile_pic = '$oldpic' WHERE msg_to = '$username'");
            }

            if (($uploadedFile1['error'] == 0) && ($uploadedFile2['error'] == 0)) {
                $uploadedFilePath1 = upload($uploadedFile1, $directory);
                $uploadedFilePath2 = upload($uploadedFile2, $directory);
                mysqli_query($conn, "UPDATE user SET profile_pic = '$uploadedFilePath1', bgpic = '$uploadedFilePath2' WHERE user_name = '$username'");
                mysqli_query($conn, "UPDATE chatting SET profile_pic = '$uploadedFilePath1' WHERE msg_to = '$username'");
            }

            if (($uploadedFile1['error'] === 0)) {

                unlink($oldpic);
            }
            if (($uploadedFile2['error'] == 0)) {
                unlink($oldbg);
            }

            if (($uploadedFile1['error'] == 0) && ($uploadedFile2['error'] == 0)) {
                unlink($oldbg);
                unlink($oldpic);
            }




            global $linkname2;
            global $activepage;
            if ($uploadedFilePath1 || $uploadedFilePath2) {
                echo '<script> alert("Upload success! ")</script>;';
                echo   '<script>window.location.replace("admindashboard.php")</script>';
            } else {
                echo '<script>alert("Nothing changed!")</script>';
                echo   '<script>window.location.replace("admindashboard.php")</script>';
            }
        }
    }

    ?>


</div>
    <script src="admin.js"></script>
    </body>

</html>