<?php

?>

<header class="forum-main-header">
    <div class="forum-header"></div>
    <div class="forum-nav-bg">
    </div>
    <nav class="forum-navbar">
        
        <div class="forum-main-head">
        <p>Clan's Longue</p>
        </div>
    </nav>

</header>

<main class="forum-main">
  
    <div class="forum-category">
   <?php 
   global $conn;
            
            $fconn = mysqli_query($conn, "SELECT * FROM category");
            while ($rows = mysqli_fetch_assoc($fconn)){
                $id = $rows['cat_id'];
                $cat_name = $rows['cat_name'];
                echo '<a href="posts.php?clan_id='.$id.'"> '.$cat_name.' </a>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. kimbab Modi nam labore quisquam mollitia praesentium numquam repudiandae dolorum doloremque, commodi impedit earum repellat eum beata</p>';
            }
   ?> 
        </div>
</main>
<section>
<div class="home-btn-all">
    <a href="../index.php">Home</a>
</div>
</section>
