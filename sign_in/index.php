<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: \SeventeenJuly\staff\store");
    exit;
}
 
// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT userID, username, password, role FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userID"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["role"] = $role;
                            // Redirect user to welcome page
                            if ($role == "admin"){
                                header("location: \SeventeenJuly\admin\staff_list\index.php?id=0");
                            } else if ($role == "staff"){
                                header("location: \SeventeenJuly\staff\store");
                            } else {
                                header("location: \SeventeenJuly\homepage");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Main StyleSheet -->
        <link rel="stylesheet" href="signin.css">
        <link rel="stylesheet" href="/SeventeenJuly/top_menu.css">
        <!-- Logo -->
        <link rel="icon" href="\SeventeenJuly\july.png">

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
                $navigation_bar = dirname(__DIR__) . "\general_navigation_bar.php";
                include $navigation_bar;
            ?>
            
            <!-- Content-->
            <div id="content">
                <img class="wave" src="wave.png">
                <div class="left-content">
                    <img src="bg.svg">
                </div>
                
                <div class="right-content">
                    <div class="content-logo">
                        <img src="\SeventeenJuly\july.png">
                    </div>
                
                    <form method="POST" action="index.php">
                        <!-- Username -->
                        <input class="inputbox <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" 
                        type="text" name="username" placeholder="Email Address" value="<?php if(isset($username)){echo $username;} ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>

                        <!-- Password -->
                        <input id="password" class="inputbox <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" 
                        type="password" name="password" placeholder="Password">
                            <span class="help-block"><?php echo $password_err; ?></span>

                        <div class="bot-detail">
                            <!-- Keep Me SignIn -->
                            <div>
                                <label for="showpw" style="word-wrap:break-word">
                                    <input id="showpw" type="checkbox" onclick="showPw()">Show Password
                                </label>
                            </div>
                        
                        </div>

                        <!-- Sign In button -->
                        <div>
                            <input class="submitbtn" type="submit" name="login" value="SIGN IN">   
                        </div>

                        <!-- Redirect to Sign Up Page -->
                        <div class="join-detail">
                            <p>Not a member? &nbsp; <a href="\SeventeenJuly\register">Sign Up.</a></p>
                        </div>

                        <input type="hidden" name="page" value=<?php if(isset($page)){echo '"' . $page . '"'; }?>>
                    </form>
                </div>    
            </div>
        </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <script src="signin.js" async defer></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </body>
</html>
