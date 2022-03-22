<?php
    session_start();
    require_once "components/db_connect.php";

    $sql = "select * from products";
    $result = mysqli_query($connect, $sql);
    $tcontent = "";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $tcontent .= "<tr>
                <td><img class='img-thumbnail' src='pictures/" .$row['prod_pic']."'</td>
                <td>" .$row['prod_name']."</td>
                <td>" .$row['prod_stock']."</td><td>";
            if(isset($_SESSION["user"])){
                $tcontent .= "<form action='products/actions/a_cart.php' method='post'>
                <input class='w-25' type='number' name='amount'></td><td><button class='btn btn-primary btn-sm' type='submit' name='addcart'>Add to cart</button></a><input type='hidden' name='prod_id' value='$row[prod_id]'></form>";
            }
            if(isset($_SESSION["adm"])){
                $tcontent .= " <a href='products/update.php?prod_id=" .$row['prod_id']."'><button class='btn btn-warning btn-sm' type='button'>Edit</button></a>
                <a href='products/delete.php?prod_id=" .$row['prod_id']."'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>";
            }
            $tcontent .= " <a href='products/details.php?prod_id=" .$row['prod_id']."'><button class='btn btn-primary btn-sm' type='button'>Details</button></a></td></tr>";
        }
    }
    else{
        $tcontent = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
    }
    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>eCom</title>
        <?php require_once 'components/boot.php'?>
        <style type="text/css">
            .manageProduct {           
                margin: auto;
            }
            .img-thumbnail {
                width: 70px !important;
                height: 70px !important;
            }
            td {          
                text-align: center;
                vertical-align: middle;
            }
            tr {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="manageProduct w-75 mt-3">    
            <div class='mb-3'>
                <?php
                if(!isset($_SESSION["adm"]) && !isset($_SESSION["user"])){
                    echo '<a href= "login.php"><button class="btn btn-success" type="button" >Login</button></a>';
                }
                if(isset($_SESSION["adm"])){
                    echo '<div class="d-flex justify-content-between">
                    <a href= "logout.php?logout"><button class="btn btn-danger" type="button" >Logout</button></a> <div>
                    <a href= "products/create.php"><button class="btn btn-primary" type="button" >Add product</button></a>
                    <a href= "adminpanel.php"><button class="btn btn-warning" type="button" >Admin panel</button></a>
                    </div></div>';
                }
                elseif(isset($_SESSION["user"])){
                    echo ' <div class="d-flex justify-content-between">
                    <div>
                    <a href= "logout.php?logout"><button class="btn btn-danger" type="button" >Logout</button></a> <a href= "user.php"><button class="btn btn-primary" type="button" >Profile</button></a>
                    </div>
                    <a href= "products/cart.php"><button class="btn btn-primary" type="button" >Cart</button></a>
                    </div>';
                }
                
                ?>
            </div>
            <p class='h2'>Products</p>
            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <?php if(isset($_SESSION["user"])){
                            echo "<th>Amount</th>";
                        } ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $tcontent;?>
                </tbody>
            </table>
        </div>
    </body>
</html>