<?php

session_start();
// Include config file
$config_file = dirname(__DIR__, 2) . "\config.php";
include $config_file;

$userID = $_GET['userID'];

$query = 'DELETE FROM users WHERE userID="'.$userID.'"';



if (mysqli_query($link, $query)){
    echo "<script>alert('Successfully removed.');window.location.href = 'index.php?id=0'</script>";
}



?>