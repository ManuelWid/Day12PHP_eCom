<?php
    session_start();
    require_once "../../components/db_connect.php";

    if($_GET["prod_id"]){
        $id = $_GET["prod_id"];
        $sql = "delete from cart where fk_prod_id = $id";
        if(mysqli_query($connect, $sql)){
            header("Location: ../cart.php");
        }   
        else{header("Location: ../../error.php");}
    }
    mysqli_close($connect);

?>