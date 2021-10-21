<?php
// Initialize the session
session_start();

// Check if the user has already logged in, if no then redirect him to login page
if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: \SeventeenJuly\sign_in");
    exit;
}

// Include config file
$config_file = dirname(__DIR__, 2) . "\config.php";
include $config_file;

// Clear session data
$_SESSION["chosen_shoes"] = "";
$_SESSION["price"] = "";

// Query for promotion shoes
$promo = mysqli_query($link, "SELECT shoesName, discount FROM promotion ORDER BY shoesName ASC");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $check = 0;

    // Check search bar if it is blank or has keywords
    if (empty($_POST["search"])) {
        $sql = "SELECT name, price FROM shoes WHERE ";
    } else {
        $search = $_POST["search"];
        $sql = "SELECT name, price FROM shoes WHERE name LIKE '%" . $search . "%'";
        $check = 1;
    }
   
    // Check Filter 
    if (isset($_POST["brand"])) { 
        // If the checkbox is the 1st checked checkbox, no need add "AND" in th query
        if (empty($check)) { 
            $check = 1;
        } else {
            $sql .= " AND ";
        }

        // Check options checked to add to query
        $brand = $_POST["brand"];
        $sql .= "(''";
        for ($i = 0; $i < count($brand); $i++){
            $sql .= " OR " . $brand[$i];
        }
        $sql .= ")";
    }

    if (isset($_POST["gender"])) {
        // If the checkbox is the 1st checked checkbox, no need add "AND" in th query
        if (empty($check)) {
            $check = 1;
        } else { 
            $sql .= " AND "; 
        }

        // Check options checked to add to query
        $gender = $_POST["gender"];
        $sql .= "(''";
        for ($i = 0; $i < count($gender); $i++){
            $sql .= " OR " . $gender[$i];
        }
        $sql .= ")";
    }
    
    // If all options are empty, select all shoes
    if (empty($_POST["search"]) && empty($_POST["brand"]) && empty($_POST["gender"])) {
        $sql = "SELECT name, price FROM shoes";
    }
        
    // All shoes are order by name
    $sql .= " ORDER BY name ASC";

    // Execute sql query
    $result= mysqli_query($link, $sql);

} else {
    $result = mysqli_query($link, "SELECT name, price FROM shoes ORDER BY name ASC");
    $promo = mysqli_query($link, "SELECT shoesName, discount FROM promotion ORDER BY shoesName ASC");
}

// Store results
while($row = mysqli_fetch_array($result)) {
    $names[] = $row['name'];
    $price[] = $row['price'];
}

while($row = mysqli_fetch_array($promo)) {
    $promo_names[] = $row['shoesName'];
    $discount[] = $row['discount'];
}

// Store results in sessions
$_SESSION["promo_names"] = $promo_names;
$_SESSION["discount"] = $discount;

if (isset($_POST["show-promo"])) {
    $showpromo = $_POST["show-promo"];
}
// Display Shoes
function showShoes($shoesName, $price , $promo_names, $discount, $x) {
    // Check if shoes are in promotion, then display promotion banner
    if(in_array($shoesName , $promo_names)) {
    echo 
    '<div class="shoes-img-container">
        <div class="chkbox-shoesname">
            <input type="checkbox" class="chkbox" name="shoesname[]" value="' . $shoesName .'">
            <p>'. $shoesName .  '</p>
        </div>
        <img class="shoes-img" src="\SeventeenJuly\shoes image\\'. $shoesName . '.jpg">
        <p>RM '. number_format((float)($price * (1 - $discount[$x])), 2, ".", "") . 
        '</p><p class="discount">Discount: ' . $discount[$x] * 100 . '%</p>
    </div>';
    } else {
        echo 
    '<div class="shoes-img-container">
        <div class="chkbox-shoesname">
            <input type="checkbox" class="chkbox" name="shoesname[]" value="' . $shoesName . '">
            <p>'. $shoesName .  '</p>
        </div>
        <img class="shoes-img" src="\SeventeenJuly\shoes image\\'. $shoesName . '.jpg">
        <p>RM '. $price . '</p>
    </div>';

    }
}

function showPromoShoes($shoesName, $price , $promo_names, $discount, $x) {
    // Check if shoes are in promotion, then display promotion banner
    if(in_array($shoesName , $promo_names)) {
    echo 
    '<div class="shoes-img-container">
        <div class="chkbox-shoesname">
            <input type="checkbox" class="chkbox" name="shoesname[]" value="' . $shoesName .'">
            <p>'. $shoesName .  '</p>
        </div>
        <img class="shoes-img" src="\SeventeenJuly\shoes image\\'. $shoesName . '.jpg">
        <p>RM '. number_format((float)($price * (1 - $discount[$x])), 2, ".", "") . '</p><p class="discount">Discount: ' . $discount[$x] * 100 . '%</p>
    </div>';
    }
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
        <title>Store</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Repeated Element -->
        <link rel="stylesheet" href="\SeventeenJuly\staff\styles.css">
        <!-- Main CSS Stylesheet -->
        <link rel="stylesheet" href="store.css">
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
                $navigation_bar = dirname(__DIR__, 2) . "\staff_navigation_bar.php";
                include $navigation_bar;
            ?>

            <!-- Content -->
            <div id="content">   
                <!-- Search - Filter -->
                    
                    <div>
                    <!-- Search -->
                        <form  class="search-filter" method="POST" action="index.php">
                        <div class="search">
                            <input type="text" class="search-bar" name="search" placeholder="Search" value="<?php if(isset($_POST["search"])){ echo $_POST["search"];} ?>">
                            <button type="submit"><i class="fa fa-search search-icon"></i></button>
                        </div>

                    <!-- Filter -->
                        <!-- Brand -->
                        <div class="dropdown">
                            <button type="button" class="dropbtn" id="dropbtn0">Brand</button>
                            <div class="dropdown-content" id="filter0">
                                <!-- Nike -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($brand)){if(in_array("brand='nike'", $brand)){echo "checked='checked'";}else { echo "";}} ?> onChange="this.form.submit()" name="brand[]" value="brand='nike'">Nike
                                </label>
                                <!-- Adidas -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($brand)){if(in_array("brand='adidas'", $brand)){echo "checked='checked'";}else { echo "";}} ?> onChange="this.form.submit()" name="brand[]" value="brand='adidas'">Adidas
                                </label>
                                <!-- Puma -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($brand)){if(in_array("brand='puma'", $brand)){echo "checked='checked'";}else { echo "";}} ?> onChange="this.form.submit()" name="brand[]" value="brand='puma'">Puma
                                </label>
                                <!-- Converse -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($brand)){if(in_array("brand='converse'", $brand)){echo "checked='checked'";}else { echo "";}} ?> onChange="this.form.submit()" name="brand[]" value="brand='converse'">Converse
                                </label>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="dropdown">
                            <button type="button" class="dropbtn" id="dropbtn1">Gender</button>
                            <div class="dropdown-content" id="filter1">
                                <!-- Men -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($gender)){if(in_array("gender='M'", $gender)){echo "checked='checked'";}else { echo "";}} ?> onchange="this.form.submit()" name="gender[]" value="gender='M'">Men
                                </label>
                                <!-- Women -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($gender)){if(in_array("gender='F'", $gender)){echo "checked='checked'";}else { echo "";}} ?> onchange="this.form.submit()" name="gender[]" value="gender='F'">Women
                                </label>
                                <!-- Kids -->
                                <label style="word-wrap:break-word">
                                    <input type="checkbox" <?php if(isset($gender)){if(in_array("gender='K'", $gender)){echo "checked='checked'";}else { echo "";}} ?> onchange="this.form.submit()" name="gender[]" value="gender='K'">Kids
                                </label>
                            </div>
                        </div>

                        <!-- Show Promotion Only -->
                        <div class="show-promo">
                            <input type="checkbox" <?php if(isset($showpromo)){echo "checked='checked'";} else {echo "";} ?> name="show-promo" onchange="this.form.submit()">Show Promotion Only
                        </div>
                        </form>
                    </div>
                    
                <!-- Shoes Picture -->
                <div>
                    <form class="content-shoes" id="shoes" method="POST">

                    <!-- Load Shoes Info from Database -->
                        <?php
                            if (isset($names) && isset($price) && !isset($showpromo)) {
                                $x = -1;
                                for ($i = 0; $i < count($names); $i++) {
                                    if(in_array($names[$i] , $_SESSION["promo_names"])) {
                                        $x = $x + 1;
                                    }
                                    showShoes($names[$i], $price[$i], $_SESSION["promo_names"], $_SESSION["discount"], $x);
                                }
                            }elseif (isset($showpromo)){
                                $x = -1;
                                for ($i = 0; $i < count($names); $i++) {
                                    if(in_array($names[$i] , $_SESSION["promo_names"])) {
                                        $x = $x + 1;
                                    }
                                    showPromoShoes($names[$i], $price[$i], $_SESSION["promo_names"], $_SESSION["discount"], $x);
                                }
                            }
                            
                        ?>
                    
                </div> 
            </div>

            <div id="remove-confirm">  
                <div class="remove-message">
                </div><br>
                <div class="remove-shoes-list"></div><br>
                    <button class="remove-yes" formaction="remove_shoes.php">YES</button>
                    <button class="remove-no">NO</button>
            </div>

            <div id="promo-confirm">  
                <div class="promo-message">
                </div><br>
                <div class="promo-shoes-list"></div><br>
                    <button class="promo-yes" formaction="remove_promotion.php">YES</button>
                    <button class="promo-no">NO</button>
            </div>

            <!-- Alert box for checkbox options -->
            <div id="confirm">  
                <div class="message">
                </div><br><br>
                <button class="yes">OK</button>
            </div>     

            <!-- Footer -->
            <div id="item-setting">
                <!-- Add Item -->
                <div class="button">
                    <button type="button" onclick="toAddItem()" class="item-button">Add New Shoes</button>
                </div>
                <!-- Remove Item -->
                <div class="button">
                    <button type="button" onclick="checkBoxCheck(this.id)" name="remove" id="remove_shoes" class="item-button">Remove Shoes</button>
                </div>
                <!-- Add to Promotion -->
                <div class="button">
                    <button onclick="return checkBoxCheck(this.id)" formaction="\SeventeenJuly\staff\store\add_promo\index.php" id="promotion" class="item-button">Add to Promotion</button>
                </div>
                <!-- Remove from Promotion -->
                <div class="button">
                    <button type="button" onclick="checkBoxCheck(this.id)" name="promo" id="remove_promo" class="item-button">Remove from Promotion</button>
                </div>
            </div>
            </form>

            

            
        </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Load php array into javascript array -->    
        <script>var promo_names = <?php echo json_encode($_SESSION["promo_names"]); ?>;</script>
        <!-- Main javascript sheet -->  
        <script src="store.js"></script>
        <!-- Fontawesome Icon -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </body>
</html>