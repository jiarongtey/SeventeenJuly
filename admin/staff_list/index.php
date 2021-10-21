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


    
$users = "SELECT * FROM users WHERE (role='admin' OR role='staff');" ;
$result_user = mysqli_query($link, $users);

while($row = mysqli_fetch_array($result_user)) {
    $userID[] = $row['userID'];
    $password[] = $row['password'];
    $firstname[] = $row['first_name'];
    $lastname[] = $row['last_name'];
    $gender[] = $row['gender'];
    $dob[] = $row['dob'];
    $role[] = $row['role'];
    $contact[] = $row['contact'];
    $country[] = $row['country'];
    $email[] = $row['username'];
}

$id  = $_GET['id'];

$user_task = 'SELECT * FROM task JOIN users ON task.userID = users.userID WHERE task.userID=' . $userID[$id] . ' AND (role="admin" OR role="staff");';
$result_task = mysqli_query($link, $user_task);

while($row = mysqli_fetch_array($result_task)){
        $task[] = $row['description'];
        $status[] = $row['status'];
        //$datecreated[] = $row['taskcreated'];
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
        <title>Staff List</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="userprofile.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
    
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
    </head>
    <body>
        <div class="desktop-container">

            <?php  $admin_navigation_bar = dirname(__DIR__, 2) . "\admin_navigation_bar.php";
               
                    include $admin_navigation_bar;
    
                 ?>



            <!-- Content-->
            <div class="content">
                <div class="leftcontainer">
                    <div class="stafflist">
                        <div><h2>Employees</h2></div>
                        <?php
                            for ($i = 0; $i < count($userID); $i++){
                                echo "<div class='staff'><a href=index.php?id=". $i . ">" . $firstname[$i] . " " . $lastname[$i] . "</div></a>";
                            }
                        ?>

                    </div>

                </div>
                <div class="rightcontainer">
                    <div class="topcontainer">
                        <?php 
                            echo '<h2>' . $firstname[$id] . ' ' . $lastname[$id] . '</h2>';
                        ?>
                    </div>
                    <div class="staffinfo">
                        <img class="avatar" src="/SeventeenJuly/example.png" alt="Avatar">
                        <div class="infoleft">
                            <h3>First Name:</h3>
                            <h3>Last Name:</h3>
                            <h3>Gender</h3>
                            <h3>Country<h3>
                            <h3>Date of Birth:</h3>
                            <h3>Position:</h3>
                            <h3>Contact:</h3>
                            <h3>Email:</h3>
                        </div>

                        <div class="inforight">
                        
                        <?php                       
                            echo "<div class='editable'><h3>" . $firstname[$id] . "</h3></div> "; 
                            echo "<div class='editable'><h3>" . $lastname[$id] . "</h3></div>";
                            echo "<div class='editable'><h3>" . $gender[$id] . "</h3></div>";
                            echo "<div class='editable'><h3>" . $country[$id] . "</h3></div>";

                            echo "<div class='editable'><h3>" . $dob[$id] . "</h3></div>";
                            echo "<div class='editable'><h3 id='position'>" . $role[$id] . "</h3><img src='/SeventeenJuly/edit.png' class='edit-img' id='editposition' onclick='rolechange()'></div>";
                            echo "<div class='editable'><h3 id='contact'>" . $contact[$id] . "</h3><img src='/SeventeenJuly/edit.png' class='edit-img' id='editcontact' onclick='contact()'></div>";
                            echo "<div class='editable'><h3 id='email'>" . $email[$id] . "</h3><img src='/SeventeenJuly/edit.png' class='edit-img' id='editemail' onclick='email()'></div>";
                            echo '<form method="GET" action="update.php">';
                            echo "<input type='hidden' name='user_id' value='".$userID[$id] ."'>";
                            echo "<input type='hidden' name='id' value='".$id ."'>";
                            echo "<div id='div_role'><input type='hidden' id='chg_role' name='c_role' value='".$role[$id] ."'></div>";
                            echo "<div id='div_contact'><input type='hidden' id='chg_contact' name='c_contact' value='".$contact[$id] ."'></div>";
                            echo "<div id='div_email'><input type='hidden' id='chg_email' name='c_email' value='".$email[$id] ."'></div>";

                            
                            
                        ?>

      
                        </div>
                        
                        
                        
                        <script>




                        function rolechange(){
                            
                            var text = prompt('Please enter new position');
                            if(text == null || text == ""){
                                alert("Please try again.")
                            }else{
                                if(text == "admin" || text == "staff"){
                                    document.getElementById("position").innerHTML = text;
                                    document.getElementById("div_role").innerHTML = "<input type='hidden' id='chg_role' name='c_role' value='"+text+"'>";


                                }else{
                                    alert("Please enter valid keyword. (Staff/Admin)");
                                }


                            }
                        }
                        function contact(){
                            
                            var text = prompt('Please enter new contact number');
                            
                            if(text == null || text == ""){
                                alert("Please try again.")
                            }else{
                                document.getElementById("contact").innerHTML = text;
                                document.getElementById("div_contact").innerHTML = "<input type='hidden' id='chg_contact' name='c_contact' value='"+text+"'>";


                            }
                        }
                        function email(){
                            
                            var text = prompt('Please enter new email');
                            
                            if(text == null || text == ""){
                                alert("Please try again.")
                            }else{
                                document.getElementById("email").innerHTML = text;
                                document.getElementById("div_email").innerHTML = "<input type='hidden' id='chg_email' name='c_email' value='"+text+"'>";

                            }
                        }


                        </script>
                        <div class="update">
                            <div>
                            <input type="submit" value ="SAVE">
                            </form>
                            <form method='GET' action='delete.php'>

                            <input type='hidden' name='userID' value=<?php echo $userID[$id] ?>>
                            <input type="submit" value ="DELETE">

                            </form>
                            </div>

                            

                           

                            
                            

                            
                        

                         </div>


                        </div>
                        
                        
                    

                    <div class="Task">
                        
                    <div class="taskb">
                        

                        <h3 class="active">Task</h3>

                        <div class="task-list">
                        <?php
                                if(isset($task)){
                                    for ($i = 0; $i < count($task); $i++)               {
                                        
                                        if($status[$i] == "Y"){
                                            echo '<h5 class="yes"> Task ' . ($i + 1) . ' : ' . $task[$i] . '</h5>';
                                        }else{
                                            echo '<h5 class="no"> Task ' . ($i + 1) . ' : ' . $task[$i] . '</h5>';
                                        }
                                    }

                                } else {
                                    echo '<h5>No task given</h5>';
                                }
                        ?>
                        </div>
                    </div>
                        
                    </div>
                    <div class="buttontask">
                        
                        <?php
                            if($_SERVER["REQUEST_METHOD"] == "POST"){

                                if(array_key_exists('taskbutton',$_POST)){



                                $newtask = $_POST["task"];
                                
                                
                                $query = 'INSERT INTO task (userID, description, status) values ("' . $userID[$id] . '", "' . $newtask . '", "N")';
                                if(mysqli_query($link, $query)){
                                    echo "<script>alert('Successfully added new task.');window.location.href = 'index.php?id=".$id."'</script>";
                                }
                            }

                            }
                  
                        
                        echo '<form method="POST" action="index.php?id='. $id.'">
                            <input type="text" id="t" name="task" value="">
                            <input type="submit" class="add-task" name="taskbutton[]" value ="ADD">
                        
                        </form>';

                        ?>

                    </div>




                </div>



            </div>
            </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

       
    </body>
</html>