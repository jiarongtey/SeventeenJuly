<?php
session_start();
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

if($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_SESSION["userID"])){
	$id = $_SESSION["userID"];
	$size = $_GET['shoe_size'];
	$name = $_GET['shoename'];
	$price = $_GET['price'];
	$sql = 'SELECT * FROM cart WHERE userID=' . $id;
	$result = mysqli_query($link, $sql);
	$rowcount = mysqli_num_rows($result);
	if ($rowcount == 0) {
		$cart = 'INSERT INTO cart (userID)
		 VALUES ("' . $id . '")';
		 mysqli_query($link, $cart);
		 $result = mysqli_query($link, $sql);
		 
		
	};
	while($row = mysqli_fetch_array($result)) {
		$cartID = $row['cartID'];
	}

	$insert = 'INSERT INTO cartdetails (cartID, name, size, price)
	VALUES ("' . $cartID . '", "' . $name . '", "' . $size . '", "' . $price . '")';
	 if (mysqli_query($link, $insert)) {
		echo "<script>alert('Add to cart successfully!'); window.location.href = '/SeventeenJuly/cart'</script>";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($link);
	 }
	 mysqli_close($link);
	 
} else {
	echo "Error: ";	
	header("location: /SeventeenJuly/sign_in/");
}


?>