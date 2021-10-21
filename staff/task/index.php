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

// Select Unfishied task
$sql = "SELECT * FROM task WHERE userID=" . $_SESSION["userID"] . " AND status = 'N'";

$result = mysqli_query($link, $sql);

while($row = mysqli_fetch_array($result)) {
    $taskid[] = $row["taskID"];
    $task[] = $row['description']; 
}

// Select finished task
$sql = "SELECT * FROM task WHERE userID=" . $_SESSION["userID"] . " AND status = 'Y'";

$result = mysqli_query($link, $sql);

while($row = mysqli_fetch_array($result)) {
    $finished_task[] = $row['description']; 
}

function showNewTask($task, $taskid, $i) {
    
    echo    '<form method="POST" action="index.php">
            <div class="row">
                <p>'. ($i + 1) .'</p>
                <p class="task">'.$task[$i].'</p>
                <input type="hidden" name="taskid" value="'. $taskid[$i] .'">
                <button type="submit" class="new-task" type=submit>DONE</button>
            </div>
            </form>';
    }

function showFinishedTask($task, $finished_task, $i) {
    
    echo    '<div class="finished-row">
                <p>'. ($task + 1) .'</p>
                <p class="task">'.$finished_task[$i].'</p>
                <button class="finished-task" type="button">DONE</button>
            </div>';
    }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Get the taskid of the task
    $selectedtask = $_POST["taskid"];
    $sql = "UPDATE task SET status='Y' WHERE taskID=" . $selectedtask;

    // Execute the query    
    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Succesfully update task status!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Something wrong has occured! Please try again!'); window.location.href = 'index.php';</script>";
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
        <title>Task</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Repeated Element -->
        <link rel="stylesheet" href="\SeventeenJuly\staff\styles.css">
        <!-- Main CSS Stylesheet -->
        <link rel="stylesheet" href="task.css">
        
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
       
        </script>
    </head>
    <body>
        <div class="desktop-container">
            <!-- Top Menu -->
            <?php 
                $navigation_bar = dirname(__DIR__, 2) . "\staff_navigation_bar.php";
                include $navigation_bar;
            ?>
            
            <!-- Content -->
            <div class="content">
                <h3>Task</h3>
                <?php
                // if has uncompleted task
                if(!empty($task)) {
                    for ($i=0; $i < count($task); $i++){
                        showNewTask($task, $taskid, $i);
                    }
                }
                // if has finished task
                if(!empty($finished_task)) {
                    for ($i=0; $i < count($finished_task); $i++){
                        // if has uncompleted task, starting index after uncompleted task
                        if(isset($task)){
                            showFinishedTask(count($task), $finished_task, $i);
                        } else {
                            showFinishedTask($i, $finished_task, $i);
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    </body>
</html>