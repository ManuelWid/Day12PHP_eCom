<?php
session_start();
if(!isset($_SESSION["adm"])){
    header("Location: index.php");
    exit;
}

require_once "../components/db_connect.php";

if ($_GET['prod_id']) {
    $id = $_GET['prod_id'];
    $sql = "select * from products where prod_id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['prod_name'];
        $price = $data['prod_price'];
        $desc = $data['prod_desc'];
        $picture = $data['prod_pic'];
        $stock = $data['prod_stock'];
        $supplier = $data['fk_sup_id'];
    } else {
        header("location: error.php");
    }

    $sql2 = "select * from suppliers";
    $result2 = mysqli_query($connect, $sql2);
    $rows = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    $stroptions = "";
    foreach($rows as $row){
        if($supplier == $row["sup_id"]){
            $stroptions .= "<option selected value='{$row["sup_id"]}'>{$row["sup_name"]}</option>";
        }else{
            $stroptions .= "<option value='{$row["sup_id"]}'>{$row["sup_name"]}</option>";
        }
    }
} else {
    header("location: error.php");
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <?php require_once '../components/boot.php'?>
        <style type= "text/css">
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }  
            .img-thumbnail{
                width: 70px !important;
                height: 70px !important;
            }     
        </style>
    </head>
    <body>
        <fieldset>
            <legend class='h2'>Update request <img class='img-thumbnail rounded-circle' src='../pictures/<?= $picture ?>' alt="<?= $name ?>"></legend>
            <form action="actions/a_update.php"  method="post" enctype="multipart/form-data">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td><input class="form-control" type="text"  name="name" placeholder ="Product Name" value="<?= $name ?>"  /></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input class="form-control" type="text"  name="desc" placeholder ="Description" value="<?= $desc ?>"  /></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><input class="form-control" type= "number" name="price" step="any"  placeholder="Price" value ="<?= $price ?>" /></td>
                    </tr>
                    <tr>
                        <th>Stock</th>
                        <td><input class="form-control" type= "number" name="stock" step="any"  placeholder="Stock" value ="<?= $stock ?>" /></td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td><select name="supplier">
                            <option value="null">None</option>
                            <?= $stroptions ?>
                        </select></td>
                    </tr>
                    <tr>
                        <th>Picture</th>
                        <td><input class="form-control" type="file" name= "picture" /></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="id" value="<?= $data['prod_id'] ?>" />
                        <input type="hidden" name="picture" value="<?= $data['prod_pic'] ?>" />
                        <td><button class="btn btn-success" type="submit">Save Changes</button></td>
                        <td><a href="../index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>