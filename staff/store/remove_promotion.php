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

$shoes_name = $_POST["shoesname"];
// When remove button clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){

        
        for ($i = 0; $i < count($shoes_name); $i++) {
            
        // Prepare an insert statement
        $sql = "DELETE FROM promotion WHERE shoesName = '$shoes_name[$i]'";
                // Attempt to execute the prepared statement
                if(mysqli_query($link, $sql)){
                    header("location: \SeventeenJuly\staff\store");
                    } else {
                        echo "<script>alert('Something went wrong...')</script>";
                    }
                }
            }
        
?>


