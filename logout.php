<?php 
session_start();
if (!isset($_SESSION["login"]))
echo "<script>
        document.location.href = 'index.php';
        </script>";
session_unset();
session_destroy();
echo "<script>
alert('Good bye~');
document.location.href = 'index.php';
</script>";
exit;

?>
