<?php
// Initialize the session
session_start();

// Check if the user has already logged in, if no then redirect him to login page
if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: \SeventeenJuly\sign_in");
    exit;
}

// Include config file
$config_file = dirname(__DIR__, 3) . "\config.php";
include $config_file;

// store chosen shoes' data into session
if (isset($_POST["shoesname"])) {
    $_SESSION["chosen_shoes"] = $_POST["shoesname"];
}

//find the price for selected shoes
for ($i = 0; $i < count($_SESSION["chosen_shoes"]); $i++) {
    $sql = "SELECT price FROM shoes WHERE name = '". $_SESSION["chosen_shoes"][$i] . "'";

    $query = mysqli_query($link, $sql);
        
    while($row = mysqli_fetch_array($query)) {
        $price[] = $row['price'];
        }
}

$_SESSION["price"] = $price;

if(isset($_POST["discount"])) {
    $discount = $_POST["discount"];
}

// When submit button is pressed
if(!empty($_POST["discount"]) && isset($_POST["addpromo"])) {
            
        for ($i = 0; $i < count($_SESSION["chosen_shoes"]); $i++) {
        // Prepare an insert statement
        $sql = "INSERT INTO promotion (shoesName, discount) VALUES ('" . $_SESSION["chosen_shoes"][$i] . "', ($discount[$i] / 100))";
                if(mysqli_query($link, $sql)){
                } else{
                    echo "<script>alert('Something went wrong...')</script>";
                }
    }
    // set session to 0
    $_SESSION["chosen_shoes"] = $_SESSION["price"] = "";
    header("location: \SeventeenJuly\staff\store");
}   

function showShoes($shoesName, $price, $i) {
    echo  '<div class="row">
                    <img src="\SeventeenJuly\shoes image\\' . $shoesName . '.jpg">
                    <p>' . $shoesName . '</p>
                    <div class="price">
                        <p>RM ' . $price . '</p>
                        <label>Discount Value:
                            <input type="text" onchange="calculateDiscount(this.value, ' . $price .', ' . $i . ')" name="discount[]">%
                        </label>
                        <p id="discountedPrice'. $i .'"></p>
                    </div>
                </div>';
}
    

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add Promotion</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="\SeventeenJuly\staff\styles.css">
        <link rel="stylesheet" href="add_promo.css">
        <style>
            @font-face {
                font-family: 'adihaus';
                src: url('/SeventeenJuly/AdiHaus-Regular.ttf');
                }
            * {
                font-family: 'adihaus';
            }
        </style>
    </head>
    <body>
        <div class="desktop-container">
            <!-- Top Menu -->
            <?php 
                $navigation_bar = dirname(__DIR__, 3) . "\staff_navigation_bar.php";
                include $navigation_bar;
            ?>

            <!-- Content -->
            <div class="content">
                <h3>Add Promotion</h3>
                <form method="POST" action="index.php">
                
                <!-- Load Chosen Shoes -->
                <?php for($i = 0; $i < count($_SESSION["chosen_shoes"]); $i++ ){
                        showShoes($_SESSION["chosen_shoes"][$i], $_SESSION["price"][$i], $i);
                    }?>

                <div class="confirmation">
                    <button type=submit name="addpromo">CONFIRM</button>
                    <button type=button onclick="toStore()">CANCEL</button>
                </div>
                </form>
            </div>
        </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <script src="add_promo.js" async defer></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" async defer></script>
    </body>
</html>
