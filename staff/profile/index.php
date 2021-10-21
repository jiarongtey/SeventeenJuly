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

$sql = "SELECT * FROM users WHERE userID = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_userid);
    
    // Set parameters
    $param_userid = $_SESSION["userID"];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
    
        mysqli_stmt_bind_result($stmt, $id, $role, $username, $password, $first_name, $last_name, $dob, $country, $gender, $contact, $join_date);

        mysqli_stmt_fetch($stmt);
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
        <title>Profile</title>  
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="\SeventeenJuly\staff\styles.css">
        <link rel="stylesheet" href="profile.css">
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
        <div class="desktop-container">
            <!-- Top Menu -->
            <?php 
                $admin_navigation_bar = dirname(__DIR__, 2) . "\admin_navigation_bar.php";
                $staff_navigation_bar = dirname(__DIR__, 2) . "\staff_navigation_bar.php";
                if (($_SESSION["role"]) == "admin"){
                    include $admin_navigation_bar;
                    echo "<style> body {background-color: white;} </style>";
                } else {
                    include $staff_navigation_bar;
                }
                
            ?>
            <div class="profile-content">
                
                    <div class="profile-picture">
                        <img src="\SeventeenJuly\example.png">
                    </div>
                <div class="info">
                    <div class="mid-content">
                        <div>
                            <h4>Role: </h4><br>
                        </div>
                        <?php echo $role; ?><br><br>
                        <div>
                            <h4>Username: </h4><br>
                        </div>
                        <?php echo $username; ?><br><br>
                        <div>
                            <h4>First Name:</h4><br>
                        </div>
                        <?php echo $first_name; ?><br><br>
                        <div>
                            <h4>Last Name: </h4><br>
                        </div>
                        <?php echo $last_name; ?><br><br>
                    </div>
                <div class="right-content">
                    <div>
                        <div>
                            <h4>Date of Birth: </h4><br>
                        </div>
                        <?php echo $dob; ?><br><br>
                        <div>
                            <h4>Country: </h4><br>
                        </div>
                        <?php echo $country; ?><br><br>
                        <div>
                            <h4>Gender: </h4><br>
                        </div>
                        <?php echo $gender; ?><br><br>
                        <div>
                            <h4>Created at: </h4><br>
                        </div>
                        <?php echo $join_date; ?><br><br>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
    </body>
</html>