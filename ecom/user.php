<?php
session_start();
require_once "components/db_connect.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user']) && !isset($_SESSION['sup'])) {
    header("Location: index.php");
    exit;
}

if(isset($_SESSION['user'])){$id = $_SESSION['user'];}
elseif(isset($_SESSION['sup'])){$id = $_SESSION['sup'];}
else{$id = $_SESSION['adm'];}
$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=".$id);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCom - <?php echo $row['user_mail']; ?></title>
    <?php require_once 'components/boot.php' ?>
    <style>
        .userImage {
            width: 200px;
            height: 200px;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
        .d-flex>p{
            font-size: 2em;
        }

    </style>
</head>

<body>
    <div class="container w-75">
        <div class="hero">
            <div class="d-flex">
            <img class="userImage" src="pictures/<?php echo $row['user_pic']; ?>" alt="Something went wrong.">
            <p class="ms-4 mt-1 text-light">Hier könnte Ihre Werbung stehen.</p>
            </div>
        </div>
        <div class="container mt-3">
        <a href= "index.php"><button class="btn btn-primary" type="button" >Home</button></a>
        <a href= "userupdate.php?id=<?php echo $id ?>"><button class="btn btn-warning" type="button" >Edit profile</button></a>
        <a href= "logout.php?logout"><button class="btn btn-danger" type="button" >Logout</button></a>
        </div>
    </div>
</body>
</html>