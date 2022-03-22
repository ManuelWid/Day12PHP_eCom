<?php
session_start();
require_once "../../components/db_connect.php";

$id = $_SESSION["user"];
$sql = "select cart.*, products.prod_stock from cart join products on fk_prod_id = prod_id where fk_user_id = $id";
$res = mysqli_query($connect, $sql);
$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
foreach($data as $row){
    $newstock = $row["prod_stock"] - $row["amount"];
    $sql1 = "update products set prod_stock = $newstock where prod_id = $row[fk_prod_id]";
    mysqli_query($connect, $sql1);
    $sql2 = "delete from cart where fk_user_id = $id and fk_prod_id = $row[fk_prod_id]";
    mysqli_query($connect, $sql2);
}

mysqli_close($connect);
header("Location: ../../index.php");