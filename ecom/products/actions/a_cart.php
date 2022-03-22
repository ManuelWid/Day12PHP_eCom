<?php
session_start();
require_once "../../components/db_connect.php";


if($_POST && $_POST["amount"]){
    $id = $_SESSION["user"];
    $prodid = $_POST["prod_id"];
    $amount = $_POST["amount"];
    $sql1 = "select * from cart where fk_user_id = $id and fk_prod_id = $prodid";
    $res = mysqli_query($connect, $sql1);
    $row = mysqli_fetch_assoc($res);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $newamount = $amount + $row["amount"];
        $sql2 = "update cart set amount = $newamount where fk_prod_id = $prodid";
        if(mysqli_query($connect, $sql2)){
            header("Location: ../../index.php");
        }
        else{header("Location: ../../error.php");}
    }
    else{
        $sql = "insert into cart (fk_user_id, fk_prod_id, amount) values ('$id', '$prodid', $amount)";
        if(mysqli_query($connect, $sql)){
            header("Location: ../../index.php");
        }
        else{header("Location: ../../error.php");}
    }
}
else{header("Location: ../../index.php");}
mysqli_close($connect);