<?php

// Include config file
$config_file = dirname(__DIR__) . "\config.php";
include $config_file;
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $first_name = $last_name = $dob = $country = $gender = $contact =  "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = $dob_err = $country_err = $gender_err = $contact_err ="";
$role = "user";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif (strpos($_POST["username"], "@") == !false && strpos( $_POST["username"], ".") == !false) {
        // Prepare a select statement
        $sql = "SELECT userID FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    else {
        $username_err = "Please enter a valid email.";
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate first name
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    //validate last name
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    //validate dob
    if(empty(trim($_POST["dob"]))){
        $dob_err = "Please select your date of birth.";
    } else {
        $dob = trim($_POST["dob"]);
    }

    //validate country
    if(empty(trim($_POST["country"]) or !isset($_POST["country"]))){
        $country_err = "Please select your country.";
    } else {
        $country = trim($_POST["country"]);
    }

    //validate gender
    if(!isset(($_POST["gender"]))){
        $gender_err = "Please select your gender.";
    } else {
        $gender = trim($_POST["gender"]);
    }

    //validate contact
    if(empty(trim($_POST["contact"]))){
        $contact_err = "Please enter your phone number.";
    } else if (!is_numeric($_POST["contact"])) {
        $contact_err = "Only number is allowed";
    } else {
        $contact = trim($_POST["contact"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) 
    && empty($first_name_err) && empty($last_name_err) && empty($dob_err) 
    && empty($country_err) && empty($gender_err) && empty($contact_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (role, username, password, first_name, last_name, 
        dob, country, gender, contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_role, $param_username, $param_password, 
            $param_first_name, $param_last_name, $param_dob, $param_country, $param_gender, $param_contact);
            
            // Set parameters
            $param_role = $role;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_dob = $dob;
            $param_country = $country;
            $param_gender = $gender;
            $param_contact = $contact;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script>alert('Registered succussful!'); window.location.href = '/SeventeenJuly/sign_in';</script>";
            } else{
                echo "Something went wrong. Please try again later.";
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
        <title>Register</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Main css -->
        <link rel="stylesheet" href="register.css">
        <link rel="stylesheet" href="/SeventeenJuly/top_menu.css">
        <!-- Logo -->
        <link rel="icon" href="\SeventeenJuly\july.png">

        <!-- Google Font -->
        <link href='https://fonts.googleapis.com/css?family=Actor' rel='stylesheet'>

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
                
                <div class="content-logo">
                    <img src="\SeventeenJuly\july.png">
                </div>
                <div class="title">
                    <h4><b>BECOME OUR MEMBER</b></h4>
                </div>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <!-- Username -->
                    <input class="inputbox <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" type="text" name="username" placeholder="Email Address">
                    <span class="help-block"><?php echo $username_err; ?></span>
                    <br>
                    <!-- Role -->
                    <input type="hidden" name="role" value="user">
                    <!-- Password -->
                    <input class="inputbox <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" type="password" name="password" placeholder="Password">
                    <span class="help-block"><?php echo $password_err; ?></span>
                    <br>
                    <!-- Confirm Password -->
                    <input class="inputbox <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>" type="password" name="confirm_password" placeholder="Confirm Password">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    <br>
                    <!-- First Name -->
                    <input class="inputbox <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>" type="text" name="first_name" placeholder="First Name">
                    <span class="help-block"><?php echo $first_name_err; ?></span>
                    <br>
                    <!-- Last Name -->
                    <input class="inputbox <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>" type="text" name="last_name" placeholder="Last Name">
                    <span class="help-block"><?php echo $last_name_err; ?></span>
                    <br>
                    <!-- Dath of Birth -->
                    <input class="inputbox <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>" onfocus="(this.type='date')" type="text" name="dob" placeholder="Date of Birth">
                    <span class="help-block"><?php echo $dob_err; ?></span>
                    <br>
                    <!-- Contact -->
                    <input class="inputbox <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>" type="text" name="contact" placeholder="Phone Number">
                    <span class="help-block"><?php echo $contact_err; ?></span>
                    <br>
                    <!-- Country -->
                    <select class="inputbox <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>" id="country" name="country" placeholder="Country" required>
                        <option value="" disabled selected>Country</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Others">Others</option>
                    </select>
                    <span class="help-block"><?php echo $country_err; ?></span>
                    <!-- Gender -->
                    <div class="gender">
                        <label>
                            <input type="radio" name="gender" value="M">
                            <div class="radio-button-container <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">Male</div>
                        </label>
                        <label>
                            <input type="radio" name="gender" value="F">
                            <div class="radio-button-container <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">Female</div>
                        </label>
                    </div>
                    <span class="help-block"><?php echo $gender_err; ?></span>
                    <!-- Sign Up Button -->
                    <div>
                        <input class="submitbtn" type="submit" name="signup" value="SIGN UP">   
                    </div>

                    <!-- Redirect to Sign In Page -->
                    <div class="bot-detail">
                        <p>Already a member? &nbsp; <a href="\SeventeenJuly\sign_in">Sign In.</a></p>
                    </div>
                </form>
            </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <script src="signin.js" async defer></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </body>
</html>