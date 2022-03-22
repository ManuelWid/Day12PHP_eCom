<?php
session_start();
if(!isset($_SESSION["adm"])){
    header("Location: index.php");
    exit;
}

require_once "../components/db_connect.php";

$sql = "select * from suppliers";
$result = mysqli_query($connect, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$stroptions = "";
foreach($rows as $row){
    $stroptions .= "<option value='{$row["sup_id"]}'>{$row["sup_name"]}</option>";
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require_once '../components/boot.php'?>
        <title>eCom Add Product</title>
        <style>
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }       
        </style>
    </head>
    <body>
        <fieldset>
            <legend class='h2'>Add Product</legend>
            <form action="actions/a_create.php" method= "post" enctype="multipart/form-data">
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td><input class='form-control' type="text" name="name"  placeholder="Product Name" /></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input class='form-control' type="text" name="desc"  placeholder="Description" /></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <!-- value=0 is important as if not set and left empty in the form it would throw a fatal error
                        as the query in a_create would have an empty spot -->
                        <td><input class='form-control' type="number" name= "price" placeholder="Price" step="any" value=0 /></td>
                    </tr>
                    <tr>
                        <th>Stock</th>
                        <td><input class='form-control' type="number" name="stock"  placeholder="Stock" step="any" value=0 /></td>
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
                        <td><input class='form-control' type="file" name="picture" /></td>
                    </tr>
                    <tr>
                        <td><button class='btn btn-success' type="submit">Add product</button></td>
                        <td><a href="index.php"><button class='btn btn-primary' type="button">Home</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>