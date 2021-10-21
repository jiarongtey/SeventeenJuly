<?php

session_start();

$config_file = dirname(__DIR__) . "\config.php";
include $config_file;

// this one is based on userid change to userid in sql
$userid= $_SESSION["userID"];

$sql = "SELECT * from users where userID="  . $userid;


$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_array($result)){

    $i1[] = $row['username'];
    $i2[] = $row['password'];
    $i3[] = $row['first_name'];
    $i4[] = $row['last_name'];
    $i5[] = $row['dob'];
    $i6[] = $row['country'];
    $i7[] = $row['gender'];
    

}

$username = $i1[0];
$password = $i2[0];
$firstname = $i3[0];
$lastname = $i4[0];
$dob = $i5[0];
$country = $i6[0];
$gender = $i7[0];




?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>

    <link rel="stylesheet" href="userprofile.css">
    <link rel="stylesheet" href="\SeventeenJuly\top_menu.css">
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

<div class='content'>

    <div class='topcontent'>

        <h1>My Info.</h1>


    </div>
    <form method='POST' action='changepassword.php'>

    <div class='middlecontent'>

    <div class='details'>

    </div>

        <div class='labelinfo'>
            <h4>Email:</h4>
            <h4>First Name:</h4>
            <h4>Last Name:</h4>
            <h4>Date of Birth:</h4>
            <h4>Country:</h4>
            <h4>Gender:</h4>
        </div>

        <div class='info'>
            <h4><?php echo $username?></h4>
            <h4><?php echo $firstname?></h4>
            <h4><?php echo $lastname?></h4>
            <h4><?php echo $dob?></h4>
            <h4><?php echo strtoupper($country);?></h4>
            <h4><?php if($gender=='M'){echo 'Male';}else{echo 'Female';}?></h2>


        </div>









    </div>

</form>

</div>


</body>
</html>

