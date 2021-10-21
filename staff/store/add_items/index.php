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


// When confirm button clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $file = $_FILES["shoesimg"];
        $path = $_FILES["shoesimg"]["name"];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $brand = trim($_POST["brand"]);
        $name = trim($_POST["name"]);
        $category = trim($_POST["category"]);
        $color = trim($_POST["color"]);
        $price = trim($_POST["price"]);
        $gender = trim($_POST["gender"]);
        $description = trim($_POST["description"]);
        $size = $_POST["size"];
        $quantity = $_POST["quantity"];

        // Prepare an insert statement
        $sql = "INSERT INTO shoes (brand, name, category, color, price, gender, description) 
        VALUES ('$brand', '$name', '$category', '$color', '$price', '$gender', '$description')";
    
            
        // Attempt to execute the prepared statement
            
        if (mysqli_query($link, $sql)) {
            // Add different shoes size with quantity
            for ($i = 0; $i < count($size); $i++) {
                $query = 'INSERT INTO size (name, size, quantity) VALUES ("' . $name . '", "' . $size[$i] . '", ' . $quantity[$i] . ')';
                mysqli_query($link, $query);
            }
            // Move file to server file
            move_uploaded_file($file["tmp_name"], "C:\wamp64\www\SeventeenJuly\shoes image\\" . $name . "." . $ext);    
            echo "<script>alert('Successfully added new shoes!'); window.location.href = '/SeventeenJuly/staff/store'</script>";
        } else {
            echo "<script>alert('Something has gone wrong! Please try again'); window.location.href = '/SeventeenJuly/staff/store/add_items'</script>";
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
        <title>Add Items</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="\SeventeenJuly\staff\styles.css">
        <!-- Current Page Stylesheet -->
        <link rel="stylesheet" href="add_items.css">
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
        <script>
        $(".profile").click(function(){
    $(".dropdown-content-profile").slideToggle();
    })
        </script>
    </head>
    <body>
        <div class="desktop-container">
            <!-- Top Menu -->
            <?php 
                $navigation_bar = dirname(__DIR__, 3) . "\staff_navigation_bar.php";
                include $navigation_bar;
            ?>

            <!-- Title -->
            <div class="title">
                <h2>Add Items</h2>
            </div>

            <!-- Content-->
            <div id="content-container">
                <form method="POST"  enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    
                    <!-- left-content -->
                    <div class="left-content">

                        <!-- Brand -->
                        <div class="detailbox">
                            <div class="propertybox">
                                brand
                            </div>
                            <div>
                                <select required class="dropdownbrand" id="brand" name="brand">
                                    <option value=""></option>
                                    <option value="nike">Nike</option>
                                    <option value="adidas">Adidas</option>
                                    <option value="puma">Puma</option>
                                    <option value="converse">Converse</option>
                                </select>
                            </div>
                        </div>

                        <!-- Shoes Name -->
                        <div class="detailbox">
                            <div class="propertybox">
                                shoes name
                            </div>
                            <div>
                                <input required class="inputbox" type="text" name="name">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="detailbox">
                            <div class="propertybox">
                                category
                            </div>
                            <div>
                                <select required class="dropdownbrand" id="category" name="category">
                                    <option value=""></option>
                                    <option value="lifestyle">Lifestyle</option>
                                    <option value="running">Running</option>
                                </select>
                            </div>
                        </div>

                        <!-- Color -->
                        <div class="detailbox">
                            <div class="propertybox">
                                color
                            </div>
                            <div>
                                <input required class="inputbox" type="text" name="color">
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="detailbox">
                            <div class="propertybox">
                                price
                            </div>
                            <div>
                                <input required class="inputbox" type="text" id="price" name="price">
                            </div>
                        </div>

                        <!-- Description-->
                        <div class="descbox">
                            <div class="descpropertybox">
                                description
                            </div>
                            <textarea required class="desctypebox" name="description" placeholder=""></textarea>
                        </div>
                    </div>

                    <!-- middle-content -->
                    <div class="middle-content">

                        <!-- Gender -->
                        <div class="gender">
                            <label>
                                <input required type="radio" name="gender" value="M">
                                <div class="radio-button-container">Male</div>
                            </label>
                            <label>
                                <input type="radio" name="gender" value="F">
                                <div class="radio-button-container">Women</div>
                            </label>
                            <label>
                                <input type="radio" name="gender" value="K">
                                <div class="radio-button-container">Kids</div>
                            </label>
                        </div>
                        <div class="size-quantity">
                                <div class="mid-box">
                                    <!-- Size -->
                                    <div class="detailbox" style="width: 150px !important;">
                                        <div class="propertybox" style="width: 50px !important;">
                                            size
                                        </div>
                                        <div>
                                            <select required class="dropdownbrand" style="width: 100px !important;" id="price" name="size[]">
                                                <option value=""></option>
                                                <?php 
                                                    for ($i = 4.0; $i < 9.5; $i += 0.5) {
                                                        $i = number_format($i, 1);
                                                        echo '<option value="UK ' . $i . '">UK ' . $i . '</option>';
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="detailbox" style="width: 150px !important; margin-left: 20px;">
                                    <div class="propertybox" style="width: 70px !important;">
                                        quantity
                                    </div>
                                    <div>
                                        <input required id="quantity" class="inputbox quantity" 
                                        style="width: 50px !important; text-align: center !important;" type="text" name="quantity[]" value="0">
                                    </div>
                                </div>
                                <!-- X - Remove -->
                                <div class="remove-icon">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mid-button">
                            <button type="button" class="new-size" >Add New Size</button>
                        </div>
                    </div>

                    <!-- right-content -->
                    <div class="right-content">

                        <!-- Thumbnail -->
                        <div class="right-title">
                            <h4>Thumbnail</h4>
                            <label class="custom-file-upload">
                                <input required type="file" id="img" onchange="readURL(this);" name="shoesimg" accept="image/jpg">
                                <i class="fa fa-upload" aria-hidden="true"></i><span class="upload">Upload</span>
                            </label>
                        </div>
                        <div class="shoes-thumbnail-container">
                            <img class="shoes-thumbnail" id="thumbnail" src="\SeventeenJuly\gray pic" alt="thumbnail">
                        </div>     
                            <div class="confirmation">
                                <div class="button">
                                    <input class="con-btn" type="submit" value="Confirm">
                                </div>
                                <div class="button">
                                    <button type="button" onclick="toStore()" class="con-btn">Cancel</button>
                                </div>
                            </div>
                    </div>
                </form>

            </div>
        </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="add_items.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" async defer></script>
    </body>
</html>