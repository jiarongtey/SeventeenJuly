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


// When remove button clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Get the selected shoes name
        $shoes_name = $_POST["shoesname"];

        for ($i = 0; $i < count($shoes_name); $i++) {
            $shoes  = 'DELETE FROM shoes WHERE name = "' . $shoes_name[$i] . '"';
            $size = 'DELETE FROM size WHERE name = "' . $shoes_name[$i] . '"';
            $promotion = 'DELETE FROM promotion WHERE shoesName = "' . $shoes_name[$i] . '"';

            mysqli_query($link, $shoes);
            mysqli_query($link, $size);
            mysqli_query($link, $promotion); 
        }

        header("location: \SeventeenJuly\staff\store");
}

?>


