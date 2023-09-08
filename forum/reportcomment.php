<?php
require '../functions.php';
if (!isset($_SESSION["login"]))
    echo "<script>
        document.location.href = '../index.php';
        </script>";
?>

<?php


// global $conn;
// $data = $_POST["post"];
// $clan = $_POST["clan"];
// $ccid = $_POST["ccid"];
// $sec = $_POST["sid"];
// $txt = $_POST["txt"];
// $cid = $_POST["cid"];
// $user = $_POST["user"];


// $result = mysqli_query($conn, "SELECT * FROM comment_reported WHERE comment_id = $data AND comment_by = '$ccid' AND comment_content ='$txt' AND reported_by = '$user' AND section = '$sec' AND clan = '$clan'");

// if (mysqli_fetch_assoc($result)) {
//     return false;
// } 

//     mysqli_query($conn, "INSERT INTO comment_reported VALUES ('','$cid', '$ccid','$txt','$clan','$user', '$sec')");
//    mysqli_affected_rows($conn);


// if (mysqli_affected_rows($conn) > 0) {
//     echo '<script>

//         window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $sec . '")
//                     alert("Comment reported!")
//                     </script>';
// } else {
//     echo '<script>
//                     alert("You already report this comment!");
//                    window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $sec . '")
//                     </script>';
// }


          

                                    function reppcom()
                                    {
                                        global $conn;
                                        $data = $_POST["post"];
                                        $clan = $_POST["clan"];
                                        $ccid = $_POST["ccid"];
                                        $sec = $_POST["sid"];
                                        $txt = $_POST["txt"];
                                        $cid = $_POST["cid"];
                                        $user = $_POST["user"];

                                        
                                        

                                        $tes = mysqli_query($conn, "SELECT * FROM comment_reported WHERE comment_id = $cid AND comment_by = '$ccid' AND comment_content ='$txt' AND reported_by = '$user' AND section = '$sec' AND clan = '$clan'");

                                        if (mysqli_fetch_assoc($tes)) {
                                            return false;
                                        } else {
                                            mysqli_query($conn, "INSERT INTO comment_reported VALUES ('','$cid', '$ccid','$txt','$clan','$user', '$sec')");
                                            return mysqli_affected_rows($conn);
                                        }
                                    }


                                    $data = $_POST["post"];
                                    $clan = $_POST["clan"];
                                    $ccid = $_POST["ccid"];
                                    $sec = $_POST["sid"];
                                    $txt = $_POST["txt"];
                                    $cid = $_POST["cid"];
                                    $user = $_POST["user"];



                                    if (reppcom() > 0) {
                                        echo '<script>
                                            window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $sec . '")
                                            alert("Comment reported!")
                                            </script>';
                                    } else {
                                        echo '<script>
                                            alert("You already report this comment!");
                                            window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $sec . '")
                                        </script>';
                                    };
            
        

// echo '<script>
//            ' . mysqli_query($conn, "INSERT INTO comment_reported VALUES ('','$cid', '$ccid','$txt','$clan','$user', '$sec')") . '

//            window.location.replace("topic.php?post=' . $data . '&clan=' . $clan . '&cat=' . $sec . '")
//                             alert("Comment reported!")
//            </script>

//            ';



?>