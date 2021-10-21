<?php

session_start();
// Include config file
$config_file = dirname(__DIR__, 2) . "\config.php";
include $config_file;
$quantity = $_GET['q'];
$shoesID = $_GET['id'];

$query = 'UPDATE size SET quantity="'. $quantity .'" WHERE sizeID="'.$shoesID .'"';

if (mysqli_query($link, $query)){
    echo "<script>alert('Successfully added.');window.location.href = 'index.php?brand=all'</script>";
}


?>