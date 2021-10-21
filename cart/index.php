<?php
session_start();

$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

$id = $_SESSION["userID"];

$sql = "SELECT * from cart JOIN cartdetails ON cart.cartID = cartdetails.cartID WHERE cart.userID=" . $id;

$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)){
    $cartID[] = $row['cartID'];
    $price[] = $row['price'];
    $name[] = $row['name'];
    $sizeName[] = $row['size'];
}

$totalshoes=mysqli_num_rows($result);

?>




<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="cart_style.css">
    <link rel="stylesheet" href="\SeventeenJuly\top_menu.css">
    <script src="update.js"></script>
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
    <div class="box">
    
        <div class="header">
            <h1>Your Cart</h1>
        </div>
        <div class="headerlabel">
            <div class="labelhalf">
                
            </div>
            <div class="labelquarter">
                <span><h3>Quantity</h3></span>
            </div>
            <div class="labelquarter">
                <span><h3>Total</h3></span>
            </div>
            
        </div>
        <div class="cartrow">
        <?php
            function showcart($name,$price,$cartID,$sizename){
                    echo
            '<div class="cartitemrow">
                <div class="cartitemleft">
                    <div class="itempicture">
                    
                        <img src="/SeventeenJuly/shoes image/' . $name . '.jpg">
                        </div>
                    <div class="itemdetail">
                        <a class="itemname">' . $name . '</a>
                        <br><br>
                        <div>' . $sizename . '</div>
                        <br>
                        <form method="get" action="deleteitem.php">
                        <input type="hidden" name="deleteid" value="'.$name.'">
                        <input type="hidden" name="deleteprice" value="'.$price.'">
                        <input type="hidden" name="deletesize" value="'.$sizename.'">
                        <input type="submit" class="button" value="Remove">
                        </form>
                    </div>  
                </div>
                <div class="cartitemright">
                    <div class="labelhalf">
                        
                    </div>
                    <div class="labelquarter">
                        <span>1</span>
                    </div>
                    <div class="labelquarter">
                        <span>RM '. $price. '</span>
                    </div>
                </div>
            </div>';
            }
            $asd = 0 ;
            if(isset($name)) {
            for ($i = 0; $i < count($name); $i++) {
                showcart($name[$i], $price[$i],$cartID[$i],$sizeName[$i]);
                $asd+=$price[$i];

            }
            echo"<input type='hidden' id=totalprice value='".count($name)."'>";
        }
            ?>
        </div>

       
        <form method="get" action="checkout.php">
        <div class="cartrow">
            <div class="subtotalright">
                <div class="subtotal">
                    <span>Subtotal: </span>
                    <span><?php echo "RM ". $asd;?></span>
                </div>
                <button onclick="location.href = '/SeventeenJuly/homepage';" class="button" type="button">CONTINUE SHOPPING</button>
                <input type="hidden" name="totalshoes" value=<?php echo '"' . $totalshoes . '"'?>>

                <?php
                for($a = 0; $a < $totalshoes;$a++){
                echo"<input type='hidden' name='".$a."' value='".$sizeName[$a]."'>";
                }
                ?>


                <input type="submit" value="CHECKOUT" class="button">

            </div>
        </div>
    </form>
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
    </div>
</body>
</html>