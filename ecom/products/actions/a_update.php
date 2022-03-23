<?php
session_start();
if(!isset($_SESSION["adm"])){
    header("Location: ../../index.php");
    exit;
}

require_once "../../components/db_connect.php";
require_once '../../components/file_upload.php';

if ($_POST) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    $desc = $_POST['desc'];
    $stock = $_POST['stock'];
    $supplier = $_POST['supplier'];
    $uploadError = '';

    $picture = file_upload($_FILES['picture']); 
    if($picture->error===0){
        ($_POST["picture"]=="product.png")?: unlink("../../pictures/$_POST[picture]");           
        $sql = "UPDATE products SET prod_name = '$name', prod_price = $price, prod_desc='$desc', prod_pic = '$picture->fileName', prod_stock = '$stock', fk_sup_id = '$supplier' WHERE prod_id = $id";
    }else{
        $sql = "UPDATE products SET prod_name = '$name', prod_price = $price, prod_desc='$desc', prod_stock = '$stock', fk_sup_id = '$supplier' WHERE prod_id = $id";
    }    
    if (mysqli_query($connect, $sql)) {
        $class = "success";
        $message = "The record was successfully updated <br/> You will be redirected in 5 seconds.";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error() . "<br/> You will be redirected in 5 seconds.";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    }
    //header("refresh:5 ; url=../../index.php");
    mysqli_close($connect);
} else {
    header("location: ../../error.php");
    mysqli_close($connect);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update</title>
        <?php require_once '../../components/boot.php'?> 
    </head>
    <body>
        <div class="container">
            <div class="mt-3 mb-3">
                <h1>Update request response</h1>
            </div>
            <div class="alert alert-<?= $class;?>" role="alert">
                <p><?= ($message) ?? ''; ?></p>
                <p><?= ($uploadError) ?? ''; ?></p>
                <a href='../update.php?prod_id=<?= $id;?>'><button class="btn btn-warning" type='button'>Back</button></a>
                <a href='../../index.php'><button class="btn btn-success" type='button'>Home</button></a>
            </div>
        </div>
    </body>
</html>