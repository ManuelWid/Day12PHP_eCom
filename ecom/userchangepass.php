<?php
session_start();
require_once "components/db_connect.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
elseif($_SESSION["user"] != $_GET["id"]){header("Location: index.php");}

$class = 'd-none';
if (isset($_POST["submit"])) {
    if(isset($_POST["oldpass"]) && $_POST["newpass"] != "" && $_POST["newpass2"] != ""){
        if($_POST["newpass"] === $_POST["newpass2"]){
            $password = hash('sha256', $_POST['oldpass']);
            $newpass = hash('sha256', $_POST['newpass']);
            $id = $_SESSION["user"];
            $sql = "SELECT user_pass FROM users WHERE user_id = $id";
            $res = mysqli_query($connect, $sql);
            $data = mysqli_fetch_assoc($res);
            if($data["user_pass"] == $password){
                $sql1 = "update users set user_pass = '$newpass' where user_id = $id";
                if (mysqli_query($connect, $sql1)) {
                    $class = "alert alert-success";
                    $message = "Your password was successfully updated";
                    header("refresh:3;url=index.php");
                } else {
                    $class = "alert alert-danger";
                    $message = "Error while updating password : <br>";
                    header("refresh:3;url=index.php");
                }
            }
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCom Edit User</title>
    <?php require_once 'components/boot.php' ?>
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>

<body>
    <div class="container w-50">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>

        <h2>Update password</h2>
        <form method="post" action="">
            <table class="table">
                <tr>
                    <th>Current Password:</th>
                    <td><input class="form-control" type="text" name="oldpass" placeholder="Current Password" /></td>
                </tr>
                <tr>
                    <th>New Password:</th>
                    <td><input class="form-control" type="text" name="newpass" placeholder="New Password" /></td>
                </tr>
                <tr>
                    <th>New Password:</th>
                    <td><input class="form-control" type="text" name="newpass2" placeholder="New Password" /></td>
                </tr>
                <tr>
                    <td><button name="submit" class="btn btn-success" type="submit">Save Password</button></td>
                    <td><a href="index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>