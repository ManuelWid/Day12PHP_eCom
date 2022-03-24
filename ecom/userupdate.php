<?php
session_start();
require_once "components/db_connect.php";
require_once 'components/file_upload.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if(isset($_SESSION["adm"])){$toggle=true;}
elseif($_SESSION["user"] == $_GET["id"]){$toggle=true;}
else{$toggle=false;}

if ($toggle) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $email = $data['user_mail'];
        $picture = $data['user_pic'];
    }
}
else{
    header("Location: index.php");
    exit;
}

// cleans any input and returns it
function cleanIO($val){
    $value = trim($val);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $email = cleanIO($_POST['email']);
    $id = $_POST['id'];

    $uploadError = '';

    $pictureArray = file_upload($_FILES['picture'], "user");
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
        $sql = "UPDATE users SET user_mail = '$email', user_pic = '$pictureArray->fileName' WHERE user_id = {$id}";
    } else {
        $sql = "UPDATE users SET user_mail = '$email' WHERE user_id = {$id}";
    }
    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=index.php");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=index.php");
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
    <div class="container w-75">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>

        <h2>Update</h2>
        <img class='img-thumbnail rounded-circle' src='pictures/<?php echo $data['user_pic'] ?>' alt="Something went wrong.">
        <form method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Email</th>
                    <td><input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo $email ?>" /></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class="form-control" type="file" name="picture" /></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['user_id'] ?>" />
                    <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                    <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="index.php"><button class="btn btn-warning" type="button">Back</button></a>
                    <?php if(isset($_SESSION["user"])){
                        echo "<a href='userchangepass.php?id=".$_SESSION['user']."'><button class='btn btn-danger' type='button'>Change password</button></a></td>";
                    } ?>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>