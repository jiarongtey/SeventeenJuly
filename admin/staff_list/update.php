<?php

session_start();
// Include config file
$config_file = dirname(__DIR__, 2) . "\config.php";
include $config_file;

$query = 'UPDATE users SET role="'. $_GET['c_role'] .'", contact="'.$_GET['c_contact'].'", username="'.$_GET['c_email'] .'" WHERE userID="'.$_GET['user_id'] .'";';
$id = $_GET['id'];

if (mysqli_query($link, $query)){
    echo "<script>alert('Successfully saved.');window.location.href = 'index.php?id=".$id."'</script>";
}



?>