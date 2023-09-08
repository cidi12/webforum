<?php 
require '../functions.php';
if (!isset($_SESSION["login"]))
echo "<script>
        alert('Sign in to access the forum');
        document.location.href = '../index.php';
        </script>";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Clan's Longue</title>
</head>
<body class="forum-body">
    <div class="member">
        <?php 
       require 'userforum.php'
        ?>
    </div>
    
    
    
</body>
</html>