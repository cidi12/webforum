<?php
ini_set('display_errors', 0);
session_start();
$conn = mysqli_connect("localhost", "root", "", "webb");
function registrasi($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["regemail"]));
    $password = $data["regpass"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $pin = $data["pin"];
    $kasta = $data["kasta"];
    $userid = strtolower(stripslashes(str_replace([" ", "<br>", "<img>"],["","",""], $data["regusername"])));
    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$username'");
    $result2 = mysqli_query($conn, "SELECT user_name FROM user WHERE user_name = '$userid'");
    if (mysqli_fetch_assoc($result)) {

        return false;
    } else if (mysqli_fetch_assoc($result2)) {
        return false;
    }

    // --------------//
    if ((!empty($username))&& !empty($password) && !empty($pin)) {
        mysqli_query($conn, "INSERT INTO user VALUES('','$userid','$password', '$username', '$pin','member', 'hijau.jpg', 'memberbg.webp')");

    return mysqli_affected_rows($conn);
       
    } else {
        echo "<script>
        alert('Fill all of the fields');
        document.location.href = '';
        </script>";
    }
}


if (isset($_POST["daftar"])) {
   
    if (registrasi($_POST) > 0) {
        echo "<script>
         alert('User added!');
         document.location.href = './index.php';
         </script>";
    } else {
        echo "<script>
        alert('Username/Email already used!');
        document.location.href = './index.php';
        </script>";
    }
}

if (isset($_POST["masuk"])) {

    global $conn;
    $username = $_POST["log_email"];
    $password = $_POST["log_password"];
    $resp = mysqli_query($conn, "SELECT * FROM user WHERE email = '$username'");
    
    if (mysqli_num_rows($resp) === 1) {
        $row = mysqli_fetch_assoc($resp);
        $kasta = $row["kasta"];
        if ((password_verify($password, $row["password"])) && ($kasta == 'sultan')) {
            $_SESSION["login"] = True;
            $_SESSION["gm"] = True;
            $_SESSION["user_name"] = $row['user_name'];
            $_SESSION["kasta"] = $row['kasta'];
                 echo '<script>
                     alert("Welcome, '.$_SESSION["kasta"].' '.$_SESSION['user_name'].'");
                     window.location.replace("./admin/admindashboard.php")
                      </script>';
            } else if((password_verify($password, $row["password"])) && ($kasta == 'member')) {
                $_SESSION["login"] = True;
                $_SESSION["member"] = True;
                $_SESSION["user_name"] = $row['user_name'];
                $_SESSION["kasta"] = $row['kasta'];
                echo '<script>
                     alert("Welcome, '.$_SESSION['user_name'].'");
                     window.location.replace("./member/member.php")
                      </script>';
            }
            $error = true;
    if (isset($error)) {
        echo '<script>
        alert("Wrong email / password! ");
        window.location.replace("./index.php")
        </script>';
    }
           
        }
    

    $error = true;
    if (isset($error)) {
        echo '<script>
        alert("Wrong email / password! ");
        window.location.replace("./index.php")
        </script>';
    }

}


    ?>


