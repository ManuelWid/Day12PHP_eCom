<?php
session_start();
if (!isset($_SESSION["adm"])) {
    header("Location: index.php");
    exit;
}

require_once "components/db_connect.php";

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE user_status != '$status'";
$result = mysqli_query($connect, $sql);

$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='pictures/" . $row['user_pic'] . "' alt='Something went wrong'></td>
            <td>" . $row['user_mail'] . "</td>
            <td><a href='userupdate.php?id=".$row['user_id']."'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='userdelete.php?id=" . $row['user_id'] . "'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCom Adm-Dashboard</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
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

        .userImage {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2 mt-5">
                <img class="userImage" src="pictures/admavatar.png" alt="Adm avatar">
                <p>Neo</p>
                <a href="logout.php?logout">Sign Out</a>
            </div>
            <div class="col-8 mt-2">
                <a href= "index.php"><button class="btn btn-primary" type="button" >Back</button></a>
                <p class='h2'>Users</p>
                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>