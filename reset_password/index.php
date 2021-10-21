<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: \SeventeenJuly\sign_in");
    exit;
}
 
// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

// Define variables and initialize with empty values
$oldpassword = $newpassword = $confirmpassword = $verify = "";
$oldpassword_err = $newpassword_err = $confirmpassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if old password are empty
    if(empty(trim($_POST["oldpassword"]))){
        $oldpassword_err = "Please enter your old password.";
    } else{
        $oldpassword = trim($_POST["oldpassword"]);
    }

    // Validate New Password
    $pw_length = strlen(trim($_POST["newpassword"]));
    if(empty(trim($_POST["newpassword"]))){
        $newpassword_err = "Please enter your new password.";
    } elseif($pw_length < 8){
        $newpassword_err = "Minimum password length is 8 characters.";
    } else{
        $newpassword= trim($_POST["newpassword"]);
    }

    if ($oldpassword == $newpassword){
        $newpassword_err = "New password cannot same with old password";
    }
    // Validate Confirm Password
    if(empty(trim($_POST["confirmpassword"]))){
        $confirmpassword_err = "Please confirm your password.";
    } else{
        $confirmpassword = trim($_POST["confirmpassword"]);
    }

    if(empty($confirmpassword_err) && ($newpassword != $confirmpassword)){
        $confirmpassword_err = "Password did not match.";
    }
    
    // Validate credentials
    if(empty($newpassword_err) && empty($confirmpassword_err)){
        
        // Prepare a select statement
        $sql = "SELECT userID, password FROM users WHERE userID = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            
            // Set parameters
            $param_id = $_SESSION["userID"];
    
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){         
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($oldpassword, $hashed_password)){

                            // Password is correct, change password
                            $sql = "UPDATE users SET password = ? WHERE userID = ?";
        
                            if($stmt = mysqli_prepare($link, $sql)){
            
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
        
                                // Set parameters
                                $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
                                $param_id = $_SESSION["userID"];    
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    
                                    // Password updated successfully. Destroy the session, and redirect to login page
                                    session_destroy();
                                    header("location: \SeventeenJuly\sign_in");
                                    exit();
                                    
                                } else{
                                    echo "<script>alert('Oops! Something went wrong. Please try again later.')</script>";
                                }

                            // Close statement
                            mysqli_stmt_close($stmt);
                            }
                        } else {
                            $oldpassword_err = "Your password is not valid!";
                        }
                    }
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    } 
    // Close connection
    mysqli_close($link);
    
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
        <title>Reset Password</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="reset_password.css">
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
                $admin_navigation_bar = dirname(__DIR__) . "\admin_navigation_bar.php";
                $staff_navigation_bar = dirname(__DIR__) . "\staff_navigation_bar.php";
                $customer_navigation_bar = dirname(__DIR__) . "\customer_navigation_bar.php";
                if (($_SESSION["role"]) == "admin"){
                    include $admin_navigation_bar;
                    echo "<style> body {background-color: white;} </style>";
                } elseif (($_SESSION["role"]) == "staff") {
                    include $staff_navigation_bar;
            } else {
                include $customer_navigation_bar;
            }
                
            ?>
            
            <!-- Content -->
            <div id="content">
                <div class="content-logo">
                    <img src="\SeventeenJuly\july.png">
                </div>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <!-- Old Password -->
                    <input class="inputbox <?php echo (!empty($oldpassword_err)) ? 'has-error' : ''; ?>" 
                    type="password" name="oldpassword" placeholder="Old Password">
                        <span class="help-block"><?php echo $oldpassword_err; ?></span>
                    <br>
                    <!-- New Password -->
                    <input class="inputbox <?php echo (!empty($newpassword_err)) ? 'has-error' : ''; ?>" 
                    type="password" name="newpassword" placeholder="New Password">
                        <span class="help-block"><?php echo $newpassword_err; ?></span>
                    <br>
                    <!-- Confirm Password -->
                    <input class="inputbox <?php echo (!empty($confirmpassword_err)) ? 'has-error' : ''; ?>" 
                    type="password" name="confirmpassword" placeholder="Confirm Password">
                        <span class="help-block"><?php echo $confirmpassword_err; ?></span>

                    <div class="btn-area">
                        <!-- Reset Button -->
                        <input type="submit" name="reset-password" value="RESET PASSWORD">

                        <!-- Cancel Button -->
                        <button type="button" name="cancel" onclick="toStore()">CANCEL</button>
                    </div>
                </form>
            </div>

            
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
    <script>function toStore(){
        location.replace(<?php
    
        if (($_SESSION["role"]) == "admin"){
            echo '"/SeventeenJuly/admin/staff_list/index.php?id=0"';
        } elseif (($_SESSION["role"]) == "staff") {
            echo '"/SeventeenJuly/staff/store"';
    } 
    
        ?>)
        }</script>
        <script src="https://kit.fontawesome.com/a076d05399.js" async defer></script>
    </body>
</html>