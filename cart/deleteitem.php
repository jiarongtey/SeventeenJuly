<?php
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;


if($_SERVER["REQUEST_METHOD"] == "GET"){
 
	 
	 $name = $_GET['deleteid'];
	 $price = $_GET['deleteprice'];
	 $size = $_GET['deletesize'];

	 $sqlclear='DELETE FROM cartdetails WHERE name="' .$name . '" AND size="' . $size . '"';
	 
	 if (mysqli_query($link, $sqlclear)) {
		echo "<script>window.location.href='/SeventeenJuly/cart'</script>";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($link);
	 }
	 mysqli_close($link);
	
}




?>