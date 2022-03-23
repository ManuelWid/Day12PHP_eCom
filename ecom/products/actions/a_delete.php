<?php 
session_start();
if(!isset($_SESSION["adm"])){
    header("Location: ../../index.php");
    exit;
}

require_once "../../components/db_connect.php";

if ($_POST) {
    $id = $_POST['id'];
    $picture = $_POST['picture'];
    ($picture == "product.png")? : unlink("../../pictures/$picture");

    $sql = "DELETE FROM products WHERE prod_id = $id";
    if (mysqli_query($connect, $sql)) {
        $class = "success";
        $message = "Successfully Deleted! <br/> You will be redirected in 3 second.";
    } else {
        $class = "danger";
        $message = "An error occured: <br>" . $connect->error . "<br/> You will be redirected in 3 second.";
    }
    mysqli_close($connect);
    header("refresh: 3; url= ../../index.php");
} else {
    mysqli_close($connect);
    header("location: ../../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete</title>
        <?php require_once '../../components/boot.php'?>  
    </head>
    <body>
        <div class="container">
            <div class="mt-3 mb-3">
                <h1>Delete request response</h1>
            </div>
            <div class="alert alert-<?= $class;?>" role="alert">
                <p><?= $message;?></p>
                <a href='../../index.php'><button class="btn btn-success" type='button'>Home</button></a>
            </div>
        </div>
    </body>
</html>