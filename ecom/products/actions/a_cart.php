<?php
session_start();
require_once "../../components/db_connect.php";

if($_GET){
    var_dump($_GET);
    $sql = "insert into cart (fk_user_id, fk_prod_id, amount) values ('$_SESSION[user]', '$_GET[prod_id]', 1)";
    if(mysqli_query($connect, $sql)){
        header("Location: ../../index.php");
    }
    else{header("Location: ../../error.php");}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>