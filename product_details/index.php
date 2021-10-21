<?php

session_start();
// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

$name=$_GET["name"];
$price=$_GET["price"];
$description=$_GET["description"];
$color=$_GET["color"];
$shoesID=$_GET["id"];

$sql = "SELECT * FROM size";

$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)){

    if($name == $row['name']){
        $size[] = $row['sizeID'];
        $size_name[] = $row['size'];
        $quantity[] = $row['quantity'];
    }

   

}


?>


<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $name; ?></title>
        <link rel="stylesheet" href="productdetails_style.css">
        <link rel="stylesheet" href="\SeventeenJuly\top_menu.css">
        <style>
            @font-face {
                font-family: 'adihaus';
                src: url('/SeventeenJuly/AdiHaus-Regular.ttf');
                }

            * {
                font-family: 'adihaus';
            }

            p {
                font-family: 'adihaus' !important;
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
        <div class="product">
            <div class="column">
                <img src=<?php echo "'/SeventeenJuly/shoes image/" . $name .".jpg'"?>>
            </div>

 
            <form method="get" action="/SeventeenJuly/product_details/insert.php">
            <div class="right-column" name="name">
                <h1><?php echo $name;?></h1>

                <div class="price" name="price">
                    <span><?php echo "RM ".$price."" ;?></span>
                </div>
                
                <div id="shoesize">
                    <input type="hidden" name="shoename" value=<?php echo '"' . $name . '"'?>>
                    <input type="hidden" name="shoesID" value=<?php echo '"' . $shoesID . '"'?>>
                    <input type="hidden" name="price" value=<?php echo '"' . $price . '"'?>>
                    <div>
                        <label class="selectlabel">Size (UK)</label>
                        <select class="selector" name="shoe_size">
                            <option value=""></option>
                            <?php 
                                
                            for ($i=0; $i < count($size); $i++){
                                echo '<option value="' .$size_name[$i] .'" >' .$size_name[$i] . '
                                </option>';
                            }
                            ?>
                            </select>    
                    </div>
                    <div>
                        <button type="submit" class="btn" name="insert" value="submit">
                            <span>Add To Cart</span>
                        </button>
                    </div>
                </div>
                </form>
                <div class="description">
                    <p>
                        <?php echo $description;?>
                    </p>
                    <br>
                    <p>
                        <?php echo "Colour: ".$color."";?>
                    </p>
                </div>
            </div>
        </div>
        <br><br>
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