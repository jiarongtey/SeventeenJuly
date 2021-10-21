<?php 
session_start();
// Include config file
$config_file = dirname(__DIR__, 2) . "\config.php";
include $config_file;
    
$query_size = "SELECT * FROM `size` JOIN `shoes` ON size.name = shoes.name" ;
$result_size = mysqli_query($link, $query_size);

$nikestock = 0;
$adidasstock =0;
$pumastock = 0;
$conversestock = 0;
$totalstock = 0;

while($row = mysqli_fetch_array($result_size)) {

    $sizeID[] = $row['sizeID'];
    $size_shoesID[] = $row['shoesID'];
    $size_size[] = $row['size'];
    $size_quantity[] = $row['quantity'];

    
    $shoesBrand[] = $row['brand'];
    $shoesName[] = $row['name'];
    $shoesColor[] = $row['color'];
    $shoesPrice[] = $row['price'];
    $shoesDescription[] = $row['description'];   
}

for($i=0; $i < mysqli_num_rows($result_size);$i++){

    if($shoesBrand[$i] == 'adidas'){
        
        $adidasstock += $size_quantity[$i];
    }else if($shoesBrand[$i] == 'nike'){
        $nikestock += $size_quantity[$i];

    }else if($shoesBrand[$i] == 'puma'){
        $pumastock += $size_quantity[$i];
    }else if($shoesBrand[$i] == "converse"){
        $conversestock += $size_quantity[$i];
    }
}

$totalstock = $conversestock + $nikestock+ $pumastock+ $adidasstock;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Stock</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stock.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
        
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">

    </head>
    <body>
        <div class="desktop-container">
        <?php  $admin_navigation_bar = dirname(__DIR__, 2) . "\admin_navigation_bar.php";
               
               include $admin_navigation_bar;

            ?>

            <script>
                 function editQuantity(x,y){
                            
                            var text = prompt('Please enter the stock added.');
                            
                            if(text == null || text == "" || isNaN(text)){
                                alert("Please try again.");
                            }else{
                                var current = parseInt(document.getElementById(x).innerHTML);
                                var i = (parseInt(text) + current);
                                var shoesid = y;
                                document.getElementById(x).innerHTML = i;
                                window.location.href ='addstock.php?id=' + y + "&q=" + i;

                            }
                        }

            </script>
            
            <!-- Content-->
            <div class="content">
                <div class="overall">
                    <div class="title">
                        <a href='index.php?brand=nike'>Nike Stock</a>
                        <h1><?php echo $nikestock?></h1>


                    </div>
                    <div class="title">
                    <a href='index.php?brand=adidas'>Adidas Stock</a>
                        <h1><?php echo $adidasstock?></h1>


                    </div>
                    <div class="title">
                    <a href='index.php?brand=puma'>Puma Stock</a>
                        <h1><?php echo $pumastock?></h1>


                    </div>
                    <div class="title">
                    <a href='index.php?brand=converse'>Converse Stock</a>
                        <h1><?php echo $conversestock?></h1>


                    </div>
                    <div class="title">
                    <a href='index.php?brand=all'>Overall</a>
                        <h1><?php echo $totalstock?></h1>


                    </div>

                    


                </div>
                    <div class="stock_table">
                    <table id='table'>
                    <tr>
                        <th>Shoes Name</th>
                        <th>Brand</th>
                        <th>Size</th> 
                        <th>Stock Left</th>
                    </tr>
                    
                    <?php 
                        function showShoes($si,$ss,$sn,$sb,$sq,$x){
    
                            echo "  <tr>
                                        <td>".$sn."</td>
                                        <td>".$sb."</td>
                                        
                                        <td>".$ss."</td>
                                        <td>
                                        <a id='".$x."'onClick='editQuantity(".$x.",".$si.");' style='cursor: pointer; cursor: hand;'>".$sq."</a>
                                        </td>
                                        </tr>";
                            


                
                        
                        }
                        
                        for($i=0; $i < mysqli_num_rows($result_size);$i++){

                            if($_GET['brand']== 'all'){
                                showShoes($sizeID[$i],$size_size[$i],$shoesName[$i],$shoesBrand[$i],$size_quantity[$i],$i);

                            }else{
                                if($_GET['brand'] == 'nike' && $shoesBrand[$i] == 'nike'){

                                    showShoes($sizeID[$i],$size_size[$i],$shoesName[$i],$shoesBrand[$i],$size_quantity[$i],$i);
                                }else if($_GET['brand'] == 'adidas' && $shoesBrand[$i] == 'adidas'){
                                    
                                    showShoes($sizeID[$i],$size_size[$i],$shoesName[$i],$shoesBrand[$i],$size_quantity[$i],$i);
                                }else if($_GET['brand'] == 'puma' && $shoesBrand[$i] == 'puma'){
                                    showShoes($sizeID[$i],$size_size[$i],$shoesName[$i],$shoesBrand[$i],$size_quantity[$i],$i);
        
                                }else if($_GET['brand'] == 'converse' && $shoesBrand[$i] == 'converse'){
                                    showShoes($sizeID[$i],$size_size[$i],$shoesName[$i],$shoesBrand[$i],$size_quantity[$i],$i);
        
                                }
                            }
                            
                            
                            
                        }
                    ?>
                
                        
                    
                
                    </table>

                    

                    
                </div>


            </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    </body>
</html>