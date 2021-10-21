<?php

session_start();
// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

//Display NewArrivals
$sql = "SELECT * from shoes order by shoesID desc";

$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)){
    $shoesID[] = $row['shoesID'];
    $name[] = $row['name'];
    $price[] = $row['price'];
    $description[] = $row['description'];
    $color[] = $row['color'];
    $gender[] = $row['gender'];
}

$promoquery = "SELECT * FROM shoes JOIN promotion ON shoes.name = promotion.shoesName";

$promoresult = mysqli_query($link, $promoquery);

while ($row = mysqli_fetch_array($promoresult)){
    $promoshoesID[] = $row['shoesID'];
    $promoname[] = $row['name'];
    $promoprice[] = $row['price'];
    $discount[] = $row['discount'];
    $promodescription[] = $row['description'];
    $promocolor[] = $row['color'];
    $promogender[] = $row['gender'];
}



?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="homepage_style.css">
    <link rel="stylesheet" href="/SeventeenJuly/top_menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <?php 
                $general_navigation_bar = dirname(__DIR__) . "\general_navigation_bar.php";
                $customer_navigation_bar = dirname(__DIR__) . "\customer_navigation_bar.php";
                if (isset($_SESSION["userID"])){
                    include $customer_navigation_bar;
                } else {
                    include $general_navigation_bar;
                }
                
            ?>
<div class="imgcontainer">
    <img src="wallpaper.jpg" height="500" >
</div><br>
<div class="wordposter">
    <h2><b>NEW STORE!</b></h2>
    <h4>Good shoes take you good places</h4>
</div>
<div>
    <h2 id="newarrival">New Arrivals</h2><br>
</div>
<div class="imgborderrow">
<?php
function showShoes($shoesID,$name,$price,$description,$color){
        echo

    '<div class="imgcolumn">
    <div>
        <a href = "/SeventeenJuly/product_details/index.php?id=' . $shoesID . '&name='. $name . '&price=' . $price . '&description=' . $description . '&color=' . $color . '">
        <img src="/SeventeenJuly/shoes image/' . $name . '.jpg">
        <p><b>' . $name . '</b></p>
        <span>RM'. $price. '</span>
        </a>
    </div>
    </div>';
}

for ($i = 0; $i < 4; $i++) {
    showShoes($shoesID[$i], $name[$i], $price[$i], $description[$i], $color[$i]);
}


?>
</div>
<!--loop promotions shoes by promotion-->
<div>
    <h2 id="promotions">Promotions</h2><br>   
</div>
<div class="imgborderrow"> 
<?php
function showPromoShoes($shoesID,$name,$price,$description,$color,$discount){
        echo

    '<div class="imgcolumn">
    <div>
        <a href = "/SeventeenJuly/product_details/index.php?id=' . $shoesID . '&name='. $name . '&price=' . $price . '&description=' . $description . '&color=' . $color . '">
        <img src="/SeventeenJuly/shoes image/' . $name . '.jpg">
        <p class="discount">Discount: ' . $discount * 100 . '%</p>
        <p><b>' . $name . '</b></p>
        <span>RM'. $price. '</span>
        
    </div>
    </div>';
}
if (count($promoshoesID) > 3) {
    for ($i = 0; $i < 4; $i++) {
        showPromoShoes($promoshoesID[$i], $promoname[$i], ($promoprice[$i] * (1 - $discount[$i])), $promodescription[$i], $promocolor[$i], $discount[$i]);
    }
} else {
    for ($i = 0; $i < count($promoshoesID); $i++) {
        showPromoShoes($promoshoesID[$i], $promoname[$i], ($promoprice[$i] * (1 - $discount[$i])), $promodescription[$i], $promocolor[$i], $discount[$i]);
    }
}



?>
</div><br><br>

<div class="footer">
    <div class="gethelp">
        <li id="footertitle"><b>Get Help</b></li>
        <li>Order Status</li>
        <li>Delivery</li>
        <li>Payment Options</li>
        <li>Contact Us</li>
</div>
</body>
</html>