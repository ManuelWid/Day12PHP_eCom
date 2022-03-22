<?php
    session_start();
    require_once "../components/db_connect.php";

    $sql = "select cart.*, products.* from cart join products on prod_id=fk_prod_id where fk_user_id = $_SESSION[user]";
    $result = mysqli_query($connect, $sql);
    $tcontent = "";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $tcontent .= "<tr>
                <td><img class='img-thumbnail' src='../pictures/" .$row['prod_pic']."'</td>
                <td>" .$row['prod_name']."</td>
                <td>" .$row['amount']."</td>
                <td><a href='details.php?prod_id=" .$row['prod_id']."'><button class='btn btn-primary btn-sm' type='button'>Details</button></a> <a href='actions/a_cartdelete.php?prod_id=".$row['prod_id']."'><button class='btn btn-danger btn-sm' type='button'>Remove</button></a></td></tr>";
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
        <?php require_once '../components/boot.php'?>
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
                <div class="d-flex justify-content-between">
                <a href= "../index.php"><button class="btn btn-primary" type="button" >Back</button></a>
                <a href= "actions/order.php"><button class="btn btn-primary" type="button" >Order</button></a>
                </div>
            </div>
            <p class='h2'>Products</p>
            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Amount</th>
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