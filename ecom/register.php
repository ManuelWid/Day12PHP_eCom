<?php
session_start();
if (isset($_SESSION['user']) || isset($_SESSION['adm'])) {
    header("Location: index.php");
}

require_once "components/db_connect.php";
require_once 'components/file_upload.php';

$error = false;
$email = $pass = $picture = '';
$emailError = $passError = $picError = '';

// cleans any input and returns it
function cleanIO($val){
    $value = trim($val);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

if (isset($_POST['btn-signup'])) {
    $email = cleanIO($_POST['email']);
    $pass = cleanIO($_POST['pass']);
    $picture = file_upload($_FILES['picture'], "user");

    $uploadError = '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT user_mail FROM users WHERE user_mail='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }
    $password = hash('sha256', $pass);
    
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users(user_mail, user_pass, user_pic)
                  VALUES('$email', '$password', '$picture->fileName')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <title>eCom register</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Sign Up.</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>
            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $passError; ?> </span>
            <input class='form-control w-50' type="file" name="picture">
            <span class="text-danger"> <?php echo $picError; ?> </span>
            <hr />
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            <a href="index.php"><button class="btn btn-block btn-primary" type="button">Home</button></a>
            <hr />
            <a href="login.php">Sign in Here...</a>
        </form>
    </div>
</body>
</html>