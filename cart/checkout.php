<?php

// Initialize the session
session_start();
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;


$sql = "SELECT * from cart JOIN cartdetails ON cart.cartID = cartdetails.cartID WHERE cart.userID=" . $_SESSION["userID"];

$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)){
    $cartID[] = $row['cartID'];
    $price[] = $row['price'];
    $name[] = $row['name'];
    $sizeName[] = $row['size'];
}
$totalshoes=mysqli_num_rows($result);


if($_SERVER["REQUEST_METHOD"] == "GET"){
 
	 for ($i = 0; $i < $totalshoes; $i++){
		$sqlclear='DELETE FROM cartdetails where name="'.$name[$i].'" AND size="' . $sizeName[$i] . '"';
		mysqli_query($link, $sqlclear);
		$query_size = 'SELECT quantity FROM size where name="' . $name[$i]. '" AND size="' . $sizeName[$i] . '"';
		$result_size = mysqli_query($link, $query_size);
		$row = mysqli_fetch_array($result_size);
		$currentquantity = $row["quantity"];
		$query_update = 'UPDATE size SET quantity=' . ($currentquantity - 1) . ' where name="' . $name[$i]. '" AND size="' . $sizeName[$i] . '"';
		mysqli_query($link, $query_update);
	}

   echo "<script>alert('Thank you for purchasing!');window.location.href='/SeventeenJuly/cart'</script>";
} else {
   echo "Error: " . $sql . "
" . mysqli_error($link);
}
mysqli_close($link);




?>