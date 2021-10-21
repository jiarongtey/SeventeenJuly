<?php
session_start();
// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

$selectedbrand=$_GET["brand"];
$selectedgender=$_GET["gender"];

$sql = "SELECT * from shoes WHERE brand='" . $selectedbrand . "' AND gender='" . $selectedgender . "' order by shoesID desc";

$result = mysqli_query($link, $sql);
$totalshoes=mysqli_num_rows($result);
while ($row = mysqli_fetch_array($result)){
    $shoesID[] = $row['shoesID'];
    $name[] = $row['name'];
    $price[] = $row['price'];
    $description[] = $row['description'];
    $color[] = $row['color'];
    $gender[] = $row['gender'];
}

$promoquery = 'SELECT * FROM shoes JOIN promotion ON shoes.name = promotion.shoesName WHERE shoes.brand="' . $selectedbrand . '" AND shoes.gender="' . $selectedgender . '" order by shoes.shoesID desc';

$promoresult = mysqli_query($link, $promoquery);
$promototalshoes = mysqli_num_rows($promoresult);
while ($row = mysqli_fetch_array($promoresult)){
    $promoshoesID[] = $row['shoesID'];
    $promoname[] = $row['name'];
    $promoprice[] = $row['price'];  
    $discount[] = $row['discount'];
    $promodescription[] = $row['description'];
    $promocolor[] = $row['color'];
    $promogender[] = $row['gender'];
}
    $shoebrand = "";
            $gen = "";
            if ($selectedbrand == "nike"){
                $shoebrand = "Nike";
            }
            else if ($selectedbrand == "adidas"){
                $shoebrand = "Adidas";

            }else if ($selectedbrand == "puma"){
                $shoebrand = "Puma";

            }else{
                $shoebrand = "Converse";

            }
            if ($selectedgender == "M"){
                $gen = "Men";
            }else if ($selectedgender == "F"){
                $gen = "Women";
            }else{
                $gen = "Kids";

            }

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo "$shoebrand $gen"?></title>
        <link rel="stylesheet" href="product_style.css">
        <link rel="stylesheet" href="\SeventeenJuly\top_menu.css">
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
        
        <div class="title">
            <h2>
            <?php 

        
            echo "$shoebrand $gen"?></h2>
        </div>
        <div class="imgborderrow">
<?php
function showShoes($shoesID,$name,$price,$description,$color){
        echo

    '<div class="imgcolumn">
    <div class="shoes">
        <div>
        <a href = "/SeventeenJuly/product_details/index.php?id=' . $shoesID . '&name='. $name . '&price=' . $price . '&description=' . $description . '&color=' . $color . '">
        <img src="/SeventeenJuly/shoes image/' . $name . '.jpg">
        <p><b>' . $name . '</b></p>
        <span>RM'. $price. '</span>
        </a>
        </div>
    </div>
    </div>';
}

if ($totalshoes > 0 && $promototalshoes > 0) {
for ($i = 0; $i < count($shoesID); $i++) {
    if (!in_array($name[$i], $promoname)){
        showShoes($shoesID[$i], $name[$i], $price[$i], $description[$i], $color[$i]);
    }       
}   
} elseif ($totalshoes > 0) {
    for ($i = 0; $i < count($shoesID); $i++) {
        showShoes($shoesID[$i], $name[$i], $price[$i], $description[$i], $color[$i]);
    } 
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
        <div>
        <a href = "/SeventeenJuly/product_details/index.php?id=' . $shoesID . '&name='. $name . '&price=' . $price . '&description=' . $description . '&color=' . $color . '">
        <img src="/SeventeenJuly/shoes image/' . $name . '.jpg">
        <p class="discount">Discount: ' . $discount * 100 . '%</p>
        <p><b>' . $name . '</b></p>
        <span>RM'. $price. '</span>
        </a>
        </div>
        
    </div>
    </div>';
}
if ($promototalshoes > 0){
if (count($promoshoesID) > 3) {
    for ($i = 0; $i < 4; $i++) {
        showPromoShoes($promoshoesID[$i], $promoname[$i], ($promoprice[$i] * (1 - $discount[$i])), $promodescription[$i], $promocolor[$i], $discount[$i]);
    }
} else {
    for ($i = 0; $i < count($promoshoesID); $i++) {
        showPromoShoes($promoshoesID[$i], $promoname[$i], ($promoprice[$i] * (1 - $discount[$i])), $promodescription[$i], $promocolor[$i], $discount[$i]);
    }
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
        </div>
    </body>
</html>