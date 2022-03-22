<?php
session_start();
require_once "components/db_connect.php";

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['adm'])) {
    header("Location: adminpanel.php");
}

$error = false;
$email = $password = $emailError = $passError = '';

function cleanIO($val){
    $value = trim($val);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

if (isset($_POST['btn-login'])) {
    $email = cleanIO($_POST['email']);
    $pass = cleanIO($_POST['pass']);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    if (!$error) {
        $password = hash('sha256', $pass);

        $sql = "SELECT user_id, user_pass, user_status FROM users WHERE user_mail = '$email'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1 && $row['user_pass'] == $password) {
            if ($row['user_status'] == 'adm') {
                $_SESSION['adm'] = $row['user_id'];
                header("Location: index.php");
            } else {
                $_SESSION['user'] = $row['user_id'];
                header("Location: index.php");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
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
    <title>eCom login</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <h2>Login</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
                echo $errMSG;
            }
            ?>

            <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
            <span class="text-danger"><?php echo $emailError; ?></span>

            <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
            <span class="text-danger"><?php echo $passError; ?></span>
            <hr />
            <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign In</button>
            <hr />
            <a href="register.php">Click here to register</a>
        </form>
    </div>
</body>
</html>